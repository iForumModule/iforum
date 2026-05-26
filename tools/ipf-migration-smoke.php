<?php

define('ICMS_ROOT_PATH', dirname(__DIR__));
define('ICMS_URL', 'http://example.test');
define('XOBJ_DTYPE_INT', 1);
define('XOBJ_DTYPE_TXTBOX', 2);
define('XOBJ_DTYPE_TXTAREA', 3);
define('XOBJ_DTYPE_URL', 4);

class icms_core_Object
{
    public $vars = array();
    public $cleanVars = array();
    protected $isNew = false;
    protected $errors = array();

    public function initVar($key, $dataType, $value = null)
    {
        $this->vars[$key] = array(
            'value' => $value,
            'data_type' => $dataType,
            'persistent' => true,
        );
    }

    public function setVar($key, $value)
    {
        if (!isset($this->vars[$key])) {
            $this->initVar($key, XOBJ_DTYPE_TXTBOX);
        }
        $this->vars[$key]['value'] = $value;
    }

    public function assignVar($key, $value)
    {
        $this->setVar($key, $value);
    }

    public function assignVars($values)
    {
        foreach ($values as $key => $value) {
            $this->setVar($key, $value);
        }
    }

    public function getVar($key, $format = 's')
    {
        return isset($this->vars[$key]) ? $this->vars[$key]['value'] : null;
    }

    public function setNew()
    {
        $this->isNew = true;
    }

    public function unsetNew()
    {
        $this->isNew = false;
    }

    public function isNew()
    {
        return $this->isNew;
    }

    public function isDirty()
    {
        return true;
    }

    public function cleanVars()
    {
        $this->cleanVars = array();
        foreach ($this->vars as $key => $value) {
            $this->cleanVars[$key] = $value['value'];
        }

        return true;
    }

    public function setErrors($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function toArray()
    {
        $ret = array();
        foreach ($this->vars as $key => $value) {
            $ret[$key] = $value['value'];
        }

        return $ret;
    }
}

class icms_ipf_Object extends icms_core_Object
{
    public $handler;
}

class icms_core_ObjectHandler
{
    public $db;

    public function __construct(&$db)
    {
        $this->db = $db;
    }
}

class icms_db_criteria_Item
{
    public $field;
    public $value;
    public $operator;
    public $sort = '';
    public $order = 'ASC';
    public $limit = 0;
    public $start = 0;

    public function __construct($field, $value, $operator = '=')
    {
        $this->field = $field;
        $this->value = $value;
        $this->operator = strtoupper($operator);
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getStart()
    {
        return $this->start;
    }
}

class icms_db_criteria_Compo extends icms_db_criteria_Item
{
    public $criteria = array();

    public function __construct($criteria = null)
    {
        parent::__construct('1', 1, '=');
        if ($criteria) {
            $this->criteria[] = $criteria;
        }
    }

    public function add($criteria)
    {
        $this->criteria[] = $criteria;
    }
}

class FakeResult
{
    public $rows;
    public $index = 0;

    public function __construct($rows)
    {
        $this->rows = array_values($rows);
    }
}

class FakeDb
{
    public $tables = array();
    private $autoIds = array();
    private $lastInsertId = 0;

    public function __construct()
    {
        $this->tables = array(
            'bb_categories' => array(),
            'bb_report' => array(),
            'bb_votedata' => array(),
            'bb_digest' => array(),
            'bb_posts' => array(
                array('post_id' => 11, 'subject' => 'Reported subject', 'topic_id' => 7, 'forum_id' => 4),
            ),
            'bb_topics' => array(
                array('topic_id' => 7, 'topic_title' => 'Rated topic'),
            ),
        );
        $this->autoIds = array(
            'bb_categories' => 1,
            'bb_report' => 1,
            'bb_votedata' => 1,
            'bb_digest' => 1,
        );
    }

    public function prefix($table)
    {
        return $table;
    }

    public function genId($sequence)
    {
        if (preg_match('/^(.*)_[^_]+_seq$/', $sequence, $matches)) {
            $table = $matches[1];
            return $this->nextId($table);
        }

        return 0;
    }

    public function quoteString($value)
    {
        return "'" . addslashes((string)$value) . "'";
    }

    public function query($sql, $limit = 0, $start = 0)
    {
        if (strpos($sql, 'SELECT COUNT(*) AS vote_count, AVG(rating) AS average_rating FROM bb_votedata') === 0) {
            $rows = $this->tables['bb_votedata'];
            $count = count($rows);
            $average = 0;
            if ($count > 0) {
                $average = array_sum(array_column($rows, 'rating')) / $count;
            }

            return new FakeResult(array(array('vote_count' => $count, 'average_rating' => $average)));
        }

        if (strpos($sql, 'SELECT v.ratingid, v.topic_id, v.ratinguser, v.rating, v.ratinghostname, v.ratingtimestamp, t.topic_title FROM bb_votedata v LEFT JOIN bb_topics t ON t.topic_id = v.topic_id ORDER BY v.ratingtimestamp DESC') === 0) {
            $rows = $this->tables['bb_votedata'];
            usort($rows, function ($left, $right) {
                return $right['ratingtimestamp'] <=> $left['ratingtimestamp'];
            });
            $rows = array_slice($rows, $start, $limit ?: null);
            foreach ($rows as &$row) {
                $row['topic_title'] = '';
                foreach ($this->tables['bb_topics'] as $topic) {
                    if ((int)$topic['topic_id'] === (int)$row['topic_id']) {
                        $row['topic_title'] = $topic['topic_title'];
                        break;
                    }
                }
            }

            return new FakeResult($rows);
        }

        if (strpos($sql, 'SELECT digest_id, digest_time FROM bb_digest ORDER BY digest_time DESC, digest_id DESC') === 0) {
            $rows = $this->tables['bb_digest'];
            usort($rows, function ($left, $right) {
                if ((int)$left['digest_time'] === (int)$right['digest_time']) {
                    return (int)$right['digest_id'] <=> (int)$left['digest_id'];
                }

                return (int)$right['digest_time'] <=> (int)$left['digest_time'];
            });

            return new FakeResult(array_slice($rows, 0, 1));
        }

        if (strpos($sql, 'SELECT COUNT(*) as report_count FROM bb_report r, bb_posts p WHERE r.post_id= p.post_id') === 0) {
            $rows = $this->joinedReports();
            $rows = $this->filterReportsFromSql($rows, $sql);

            return new FakeResult(array(array('report_count' => count($rows))));
        }

        if (strpos($sql, 'SELECT r.*, p.subject, p.topic_id, p.forum_id FROM bb_report r, bb_posts p WHERE r.post_id= p.post_id') === 0) {
            $rows = $this->joinedReports();
            $rows = $this->filterReportsFromSql($rows, $sql);

            return new FakeResult(array_slice($rows, $start, $limit ?: null));
        }

        return false;
    }

    public function queryF($sql)
    {
        return $this->query($sql);
    }

    public function fetchArray($result)
    {
        if (!$result instanceof FakeResult || !isset($result->rows[$result->index])) {
            return false;
        }

        return $result->rows[$result->index++];
    }

    public function fetchRow($result)
    {
        $row = $this->fetchArray($result);
        if ($row === false) {
            return false;
        }

        return array_values($row);
    }

    public function getInsertId()
    {
        return $this->lastInsertId;
    }

    public function error()
    {
        return 'fake-db-error';
    }

    public function nextId($table)
    {
        $id = $this->autoIds[$table];
        $this->autoIds[$table]++;
        $this->lastInsertId = $id;

        return $id;
    }

    private function joinedReports()
    {
        $rows = array();
        foreach ($this->tables['bb_report'] as $report) {
            foreach ($this->tables['bb_posts'] as $post) {
                if ((int)$post['post_id'] === (int)$report['post_id']) {
                    $rows[] = array_merge($report, array(
                        'subject' => $post['subject'],
                        'topic_id' => $post['topic_id'],
                        'forum_id' => $post['forum_id'],
                    ));
                }
            }
        }

        usort($rows, function ($left, $right) {
            return (int)$left['report_id'] <=> (int)$right['report_id'];
        });

        return $rows;
    }

    private function filterReportsFromSql($rows, $sql)
    {
        if (preg_match('/r\.report_result = (\d+)/', $sql, $matches)) {
            $result = (int)$matches[1];
            $rows = array_values(array_filter($rows, function ($row) use ($result) {
                return (int)$row['report_result'] === $result;
            }));
        }

        return $rows;
    }
}

class icms_ipf_Handler extends icms_core_ObjectHandler
{
    public $_itemname;
    public $table;
    public $keyName;
    public $className;

    public function __construct(&$db, $itemname, $keyname, $identifierName, $summaryName, $modulename)
    {
        parent::__construct($db);
        $this->_itemname = $itemname;
        $this->keyName = $keyname;
    }

    public function &create($isNew = true)
    {
        $className = $this->className;
        $object = new $className($this);
        if ($isNew) {
            $object->setNew();
        }

        return $object;
    }

    public function get($id, $asObject = true)
    {
        foreach ($this->db->tables[$this->table] as $row) {
            if ((int)$row[$this->keyName] === (int)$id) {
                $object = $this->create(false);
                $object->assignVars($row);

                return $object;
            }
        }

        return $this->create();
    }

    public function insert(&$object, $force = false, $checkObject = true, $debug = false)
    {
        if ($object->isNew()) {
            $id = (int)$object->getVar($this->keyName);
            if ($id < 1) {
                $id = $this->db->nextId($this->table);
                $object->setVar($this->keyName, $id);
            }
            $this->db->tables[$this->table][] = $object->toArray();
            $object->unsetNew();

            return true;
        }

        foreach ($this->db->tables[$this->table] as $index => $row) {
            if ((int)$row[$this->keyName] === (int)$object->getVar($this->keyName)) {
                $this->db->tables[$this->table][$index] = $object->toArray();

                return true;
            }
        }

        return false;
    }

    public function delete(&$object, $force = false)
    {
        foreach ($this->db->tables[$this->table] as $index => $row) {
            if ((int)$row[$this->keyName] === (int)$object->getVar($this->keyName)) {
                unset($this->db->tables[$this->table][$index]);
                $this->db->tables[$this->table] = array_values($this->db->tables[$this->table]);

                return true;
            }
        }

        return false;
    }

    public function getObjects($criteria = null, $idAsKey = false)
    {
        $rows = $this->db->tables[$this->table];
        $rows = $this->applyCriteria($rows, $criteria);
        $rows = $this->sortRows($rows, $criteria);
        if ($criteria && method_exists($criteria, 'getStart')) {
            $rows = array_slice($rows, $criteria->getStart(), $criteria->getLimit() ?: null);
        }

        $objects = array();
        foreach ($rows as $row) {
            $object = $this->create(false);
            $object->assignVars($row);
            if ($idAsKey) {
                $objects[$row[$this->keyName]] = $object;
            } else {
                $objects[] = $object;
            }
        }

        return $objects;
    }

    public function getCount($criteria = null)
    {
        return count($this->applyCriteria($this->db->tables[$this->table], $criteria));
    }

    private function applyCriteria($rows, $criteria)
    {
        if ($criteria instanceof icms_db_criteria_Compo) {
            foreach ($criteria->criteria as $child) {
                $rows = $this->applyCriteria($rows, $child);
            }

            return $rows;
        }

        if (!$criteria instanceof icms_db_criteria_Item) {
            return $rows;
        }

        return array_values(array_filter($rows, function ($row) use ($criteria) {
            $value = isset($row[$criteria->field]) ? $row[$criteria->field] : null;
            switch ($criteria->operator) {
                case 'IN':
                    $options = array_map('trim', explode(',', trim($criteria->value, '() ')));

                    return in_array($value, $options, false);

                case '>':
                    return $value > $criteria->value;

                default:
                    return $value == $criteria->value;
            }
        }));
    }

    private function sortRows($rows, $criteria)
    {
        if (!$criteria || !method_exists($criteria, 'getSort') || $criteria->getSort() === '') {
            return $rows;
        }

        $sort = $criteria->getSort();
        $order = strtoupper($criteria->getOrder());
        usort($rows, function ($left, $right) use ($sort, $order) {
            $result = $left[$sort] <=> $right[$sort];

            return $order === 'DESC' ? -$result : $result;
        });

        return $rows;
    }
}

class icms
{
    public static $module;
    public static $user;

    public static function handler($name)
    {
        return new class {
            public function triggerEvent($category, $itemId, $event, $tags)
            {
                return true;
            }

            public function getUsers($criteria, $asObject)
            {
                return array();
            }
        };
    }
}

function iforum_isAdministrator()
{
    return false;
}

function iforum_getIP($asString = false)
{
    return $asString ? '127.0.0.1' : ip2long('127.0.0.1');
}

function iforum_updaterating($topicId)
{
    $GLOBALS['updated_topics'][] = $topicId;
}

function formatTimestamp($value, $format = '')
{
    return 'ts:' . $value;
}

function iforum_html2text($text)
{
    return strip_tags($text);
}

function icms_getmodulehandler($name, $dirname, $module = '')
{
    if ($name === 'permission') {
        return new class {
            public function getPermissions($type)
            {
                return array();
            }

            public function deleteByCategory($categoryId)
            {
                return true;
            }

            public function setCategoryPermission($categoryId)
            {
                $GLOBALS['permission_template'][] = $categoryId;

                return true;
            }
        };
    }

    throw new RuntimeException('Unexpected handler request in smoke test: ' . $name);
}

$myts = new class {
    public function displayTarea($text)
    {
        return $text;
    }
};

require_once ICMS_ROOT_PATH . '/src/class/category.php';
require_once ICMS_ROOT_PATH . '/src/class/report.php';
require_once ICMS_ROOT_PATH . '/src/class/rate.php';
require_once ICMS_ROOT_PATH . '/src/class/digest.php';

function assertTrue($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$db = new FakeDb();

$categoryHandler = new IforumCategoryHandler($db);
$category = $categoryHandler->create();
$category->setVar('cat_title', 'Announcements');
$category->setVar('cat_order', 2);
assertTrue($categoryHandler->insert($category) === 1, 'Category insert should return the new id.');
assertTrue($category->getVar('cat_id') === 1, 'Category should keep the inserted id on the object.');
assertTrue($categoryHandler->get($category->getVar('cat_id'))->getVar('cat_title') === 'Announcements', 'Category get should return the stored object.');

$reportHandler = new IforumReportHandler($db);
$report = $reportHandler->create();
$report->setVar('post_id', 11);
$report->setVar('reporter_uid', 5);
$report->setVar('reporter_ip', 123);
$report->setVar('report_time', 1000);
$report->setVar('report_text', 'Needs moderation');
$report->setVar('report_result', 0);
$report->setVar('report_memo', '');
assertTrue($reportHandler->insert($report) === 1, 'Report insert should return the new id.');
assertTrue(count($reportHandler->getByPost(11)) === 1, 'Report getByPost should find stored reports.');
assertTrue(count($reportHandler->getAllReports(0, 0, 0, 0, 'ASC', 10)) === 1, 'Report listing should return pending reports.');

$rateHandler = new IforumRateHandler($db);
$rate = $rateHandler->create();
$rate->setVar('topic_id', 7);
$rate->setVar('ratinguser', 8);
$rate->setVar('rating', 6);
$rate->setVar('ratinghostname', '127.0.0.1');
$rate->setVar('ratingtimestamp', 2000);
assertTrue($rateHandler->insert($rate) === 1, 'Rate insert should return the new id.');
$summary = $rateHandler->getAverageRating();
assertTrue($summary['vote_count'] === 1, 'Rate summary should count stored votes.');
assertTrue($summary['average_rating'] === '6.00', 'Rate summary should compute the average.');
assertTrue($rateHandler->deleteRating(1) === true, 'Rate delete should succeed for stored votes.');
assertTrue($GLOBALS['updated_topics'][0] === 7, 'Rate delete should trigger topic rating refresh.');

$digestHandler = new IforumDigestHandler($db);
$olderDigest = $digestHandler->create();
$olderDigest->setVar('digest_time', 100);
$olderDigest->setVar('digest_content', 'Older digest');
assertTrue($digestHandler->insert($olderDigest) === true, 'Digest insert should succeed.');
$latestDigest = $digestHandler->create();
$latestDigest->setVar('digest_time', 200);
$latestDigest->setVar('digest_content', 'Latest digest');
assertTrue($digestHandler->insert($latestDigest) === true, 'Second digest insert should succeed.');
$start = 0;
$digests = $digestHandler->getAllDigests($start, 5);
assertTrue(count($digests) === 2, 'Digest listing should return stored digests.');
assertTrue($digestHandler->getDigestCount() === 2, 'Digest count should match stored digests.');
assertTrue($digestHandler->delete($latestDigest) === false, 'Digest handler should reject deleting the latest digest.');
assertTrue($digestHandler->delete($olderDigest) === true, 'Digest handler should allow deleting older digests.');

$targetFiles = array(
    ICMS_ROOT_PATH . '/src/class/category.php',
    ICMS_ROOT_PATH . '/src/class/report.php',
    ICMS_ROOT_PATH . '/src/class/rate.php',
    ICMS_ROOT_PATH . '/src/class/digest.php',
);
foreach ($targetFiles as $targetFile) {
    $contents = file_get_contents($targetFile);
    assertTrue(strpos($contents, 'ArtObject') === false, basename($targetFile) . ' should not depend on ArtObject.');
    assertTrue(strpos($contents, 'ArtObjectHandler') === false, basename($targetFile) . ' should not depend on ArtObjectHandler.');
    assertTrue(strpos($contents, 'iforum_load_object') === false, basename($targetFile) . ' should not load Art objects.');
}

echo "IPF migration smoke checks passed.\n";
