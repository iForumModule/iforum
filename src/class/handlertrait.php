<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Operations the IPF handler does not provide and that iForum relies on
* (formerly supplied by the Art framework). The trait is used by the
* mod_iforum_*Handler classes that extend icms_ipf_Handler.
*
* @license   GNU General Public License (GPL)
* @package   iForum
*/

if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}

trait mod_iforum_HandlerTrait {

	/**
	 * Related table, fields and key used by the *ByLink and cleanOrphan helpers
	 */
	public $table_link;
	public $field_link;
	public $field_object;
	public $keyname_link;

	/**
	 * Load an object by its key; returns a new object for an empty id and null when not found
	 *
	 * @param mixed $id
	 * @param mixed $tags variables to fetch (array or comma separated string)
	 */
	public function &get($id, $tags = null, $debug = false, $criteria = false)
	{
		if (empty($id)) {
			$object = $this->create();
			return $object;
		}

		$ret = null;
		if (is_string($tags) && $tags !== '') {
			$tags = array($tags);
		}
		if (is_array($tags) && count($tags) > 0) {
			$select = implode(",", $tags);
			if (!in_array($this->keyName, $tags)) {
				$select .= ", " . $this->keyName;
			}
		} else {
			$select = "*";
		}
		$sql = "SELECT {$select} FROM {$this->table} WHERE {$this->keyName} = " . $this->db->quoteString($id);
		if (!$result = $this->db->query($sql)) {
			return $ret;
		}
		if (!$this->db->getRowsNum($result)) {
			return $ret;
		}

		$object = $this->create(false);
		$object->assignVars($this->db->fetchArray($result));

		return $object;
	}

	/**
	 * Insert or update an object; returns the object key on success, false on failure
	 */
	public function insert($object, $force = true, $checkObject = true, $debug = false)
	{
		// tables such as bb_posts_text use an explicit key: keep it, IPF would overwrite it with the insert id
		$key = $object->getVar($this->keyName);
		$isNew = $object->isNew();
		if (!parent::insert($object, $force, $checkObject, $debug)) {
			return false;
		}
		if ($isNew && !empty($key)) {
			$object->assignVar($this->keyName, $key);
		}
		return $object->getVar($this->keyName);
	}

	/**
	 * Get all matching objects keyed by id
	 *
	 * @param object $criteria
	 * @param array $tags variables to fetch
	 * @param bool $asObject
	 * @return array
	 */
	public function &getAll($criteria = null, $tags = null, $asObject = true)
	{
		if (is_array($tags) && count($tags) > 0) {
			if (!in_array($this->keyName, $tags)) {
				$tags[] = $this->keyName;
			}
			$select = implode(",", $tags);
		} else {
			$select = "*";
		}
		$limit = null;
		$start = null;
		$sql = "SELECT $select FROM " . $this->table;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
			if ($sort = $criteria->getSort()) {
				$sql .= " ORDER BY " . $sort . " " . $criteria->getOrder();
				$orderSet = true;
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		if (empty($orderSet)) {
			$sql .= " ORDER BY " . $this->keyName . " DESC";
		}
		$result = $this->db->query($sql, $limit, $start);
		$ret = array();
		if (!$result) {
			return $ret;
		}
		if ($asObject) {
			while ($myrow = $this->db->fetchArray($result)) {
				$object = $this->create(false);
				$object->assignVars($myrow);
				$ret[$myrow[$this->keyName]] = $object;
				unset($object);
			}
		} else {
			$object = $this->create(false);
			while ($myrow = $this->db->fetchArray($result)) {
				$object->assignVars($myrow);
				$row = array();
				foreach (array_keys($myrow) as $key) {
					$row[$key] = $object->getVar($key);
				}
				$ret[$myrow[$this->keyName]] = $row;
			}
			unset($object);
		}
		return $ret;
	}

	/**
	 * Get the keys of the objects matching a condition
	 */
	public function &getIds($criteria = null)
	{
		$ret = array();
		$sql = "SELECT " . $this->keyName . " FROM " . $this->table;
		$limit = $start = null;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		if (!$result = $this->db->query($sql, $limit, $start)) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$ret[] = $myrow[$this->keyName];
		}
		return $ret;
	}

	/**
	 * Get a limited set of objects matching a condition
	 */
	public function &getByLimit($limit = 0, $start = 0, $criteria = null, $tags = null, $asObject = true)
	{
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$criteria->setLimit($limit);
			$criteria->setStart($start);
		} elseif (!empty($limit)) {
			$criteria = new icms_db_criteria_Compo();
			$criteria->setLimit($limit);
			$criteria->setStart($start);
		}
		$ret = $this->getAll($criteria, $tags, $asObject);
		return $ret;
	}

	/**
	 * Count objects matching a condition; with a group-by criteria an array of counts per group is returned
	 */
	public function getCount($criteria = null)
	{
		$field = "";
		$groupby = false;
		if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
			if ($criteria->groupby != "") {
				$groupby = true;
				$field = $criteria->groupby . ", ";
			}
		}
		$sql = 'SELECT ' . $field . 'COUNT(*) FROM ' . $this->table;
		if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
			$sql .= ' ' . $criteria->renderWhere();
			if ($criteria->groupby != "") {
				$sql .= $criteria->getGroupby();
			}
		}
		$result = $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		if ($groupby == false) {
			list($count) = $this->db->fetchRow($result);
			return $count;
		}
		$ret = array();
		while (list($id, $count) = $this->db->fetchRow($result)) {
			$ret[$id] = $count;
		}
		return $ret;
	}

	/**
	 * Counts per key (or per group-by field) matching a condition
	 */
	public function getCounts($criteria = null)
	{
		$ret = array();
		$sql_where = "";
		$limit = null;
		$start = null;
		$groupby_key = $this->keyName;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql_where = $criteria->renderWhere();
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
			if ($groupby = $criteria->groupby) {
				$groupby_key = $groupby;
			}
		}
		$sql = "SELECT " . $groupby_key . ", COUNT(*) AS count FROM " . $this->table . " " . $sql_where . " GROUP BY " . $groupby_key;
		if (!$result = $this->db->query($sql, $limit, $start)) {
			return $ret;
		}
		while (list($id, $count) = $this->db->fetchRow($result)) {
			$ret[$id] = $count;
		}
		return $ret;
	}

	/**
	 * Delete the row of an object without going through the handler's own delete() logic
	 */
	protected function deleteRow(&$object, $force = false)
	{
		$sql = "DELETE FROM " . $this->table . " WHERE " . $this->keyName . " = " . $this->db->quoteString($object->getVar($this->keyName));
		return (bool) (empty($force) ? $this->db->query($sql) : $this->db->queryF($sql));
	}

	/**
	 * Delete all objects meeting the conditions
	 *
	 * @param object $criteria
	 * @param bool $force force the query despite security settings
	 * @param bool $asObject delete one object at a time through delete()
	 * @return bool|int
	 */
	public function deleteAll($criteria = null, $force = true, $asObject = false)
	{
		if ($asObject) {
			$objects = $this->getAll($criteria);
			foreach (array_keys($objects) as $key) {
				$this->deleteRow($objects[$key], $force);
			}
			unset($objects);
			return true;
		}
		$queryFunc = empty($force) ? "query" : "queryF";
		$sql = 'DELETE FROM ' . $this->table;
		if (!empty($criteria)) {
			if (!is_subclass_of($criteria, 'icms_db_criteria_Element')) {
				return false;
			}
			$sql .= ' ' . $criteria->renderWhere();
		}
		if (!$this->db->{$queryFunc}($sql)) {
			return false;
		}
		$rows = $this->db->getAffectedRows();
		return $rows > 0 ? $rows : true;
	}

	/**
	 * Delete the objects that have no parent row in the linked table
	 */
	public function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		return $this->removeOrphans($table_link, $field_link, $field_object);
	}

	/**
	 * Delete the objects whose $field_object has no match in $table_link.$field_link
	 */
	protected function removeOrphans($table_link = "", $field_link = "", $field_object = "")
	{
		$table_link = empty($table_link) ? $this->table_link : preg_replace("/[^a-z0-9\-_]/i", "", $table_link);
		if (empty($table_link)) {
			return false;
		}
		$field_link = empty($field_link) ? $this->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link);
		if (empty($field_link)) {
			return false;
		}
		if (empty($field_object)) {
			$field_object = empty($this->field_object) ? $field_link : $this->field_object;
		} else {
			$field_object = preg_replace("/[^a-z0-9\-_]/i", "", $field_object);
		}

		$sql = "DELETE FROM " . $this->table . " WHERE (" . $field_object . " NOT IN ( SELECT DISTINCT " . $field_link . " FROM " . $table_link . "))";
		return (bool) $this->db->queryF($sql);
	}

	/**
	 * Synchronize derived data; the default implementation removes orphans
	 */
	public function synchronization($object = null)
	{
		$this->cleanOrphan();
		return true;
	}

	/**
	 * Objects joined with a related table
	 */
	public function &getByLink($criteria = null, $tags = null, $asObject = true, $field_link = null, $field_object = null)
	{
		if (is_array($tags) && count($tags) > 0) {
			if (!in_array("o." . $this->keyName, $tags)) {
				$tags[] = "o." . $this->keyName;
			}
			$select = implode(",", $tags);
		} else {
			$select = "o.*, l.*";
		}
		$limit = null;
		$start = null;
		$field_object = empty($field_object) ? $this->field_object : preg_replace("/[^a-z0-9\-_]/i", "", $field_object);
		$field_link = empty($field_link) ? $this->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link);
		$field_object = empty($field_object) ? $field_link : $field_object;
		$sql = "SELECT $select FROM " . $this->table . " AS o LEFT JOIN " . $this->table_link . " AS l ON o." . $field_object . " = l." . $field_link;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
			if ($sort = $criteria->getSort()) {
				$sql .= " ORDER BY " . $sort . " " . $criteria->getOrder();
				$orderSet = true;
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		if (empty($orderSet)) {
			$sql .= " ORDER BY o." . $this->keyName . " DESC";
		}
		$result = $this->db->query($sql, $limit, $start);
		$ret = array();
		if (!$result) {
			return $ret;
		}
		$object = $this->create(false);
		while ($myrow = $this->db->fetchArray($result)) {
			$object->assignVars($myrow);
			if ($asObject) {
				$ret[$myrow[$this->keyName]] = clone $object;
			} else {
				$row = array();
				foreach (array_keys($myrow) as $key) {
					$row[$key] = $object->getVar($key);
				}
				$ret[$myrow[$this->keyName]] = $row;
			}
		}
		return $ret;
	}

	public function getCountByLink($criteria = null)
	{
		$sql = "SELECT COUNT(DISTINCT " . $this->keyName . ") AS count FROM " . $this->table . " AS o LEFT JOIN " . $this->table_link . " AS l ON o." . $this->field_object . " = l." . $this->field_link;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		$myrow = $this->db->fetchArray($result);
		return (int) $myrow["count"];
	}

	public function getCountsByLink($criteria = null)
	{
		$sql = "SELECT l." . $this->keyname_link . ", COUNT(*) FROM " . $this->table . " AS o LEFT JOIN " . $this->table_link . " AS l ON o." . $this->field_object . " = l." . $this->field_link;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
		}
		$sql .= " GROUP BY l." . $this->keyname_link;
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		$ret = array();
		while (list($id, $count) = $this->db->fetchRow($result)) {
			$ret[$id] = $count;
		}
		return $ret;
	}

	public function updateByLink($data, $criteria = null)
	{
		$set = array();
		foreach ($data as $key => $val) {
			$set[] = "o." . $key . "=" . $this->db->quoteString($val);
		}
		$sql = "UPDATE " . $this->table . " AS o LEFT JOIN " . $this->table_link . " AS l ON o." . $this->field_object . " = l." . $this->field_link . " SET " . implode(", ", $set);
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
		}
		return $this->db->query($sql);
	}

	public function deleteByLink($criteria = null)
	{
		$sql = "DELETE o FROM " . $this->table . " AS o LEFT JOIN " . $this->table_link . " AS l ON o." . $this->field_object . " = l." . $this->field_link;
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
			$sql .= " " . $criteria->renderWhere();
		}
		return $this->db->query($sql);
	}
}
