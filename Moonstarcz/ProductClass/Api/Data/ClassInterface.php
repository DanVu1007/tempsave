<?php

namespace Moonstarcz\ProductClass\Api\Data;

/**
 * @method mixed getData($key = '', $index = null)
 * @method $this setData($key = '', $value = null)
 */
interface ClassInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ENTITY_ID = 'entity_id';
    const STATUS = 'status';
    const NAME = 'name';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const START_TIME = 'start_time';
    const END_TIME = 'end_time';
    const MAX_STUDENT = 'max_student';
    const TOTAL_LESSON = 'total_lesson';
    const COURSE_ID = 'course_id';
    const TEACHER_ID = 'teacher_id';
    const PRODUCT = 'product_id';
    /**#@-*/

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId(int $entityId);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param bool $status
     * @return mixed
     */
    public function setStatus(bool $status);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @param $startDate
     * @return mixed
     */
    public function setStartDate($startDate);

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @param $endDate
     * @return mixed
     */
    public function setEndDate($endDate);

    /**
     * @return string
     */
    public function getStartTime();

    /**
     * @param $startTime
     * @return mixed
     */
    public function setStartTime($startTime);

    /**
     * @return string
     */
    public function getEndTime();

    /**
     * @param $endTime
     * @return mixed
     */
    public function setEndTime($endTime);

    /**
     * @return int
     */
    public function getMaxStudent();

    /**
     * @param int $maxStudent
     *
     * @return $this
     */
    public function setMaxStudent(int $maxStudent);

    /**
     * @return int
     */
    public function getTotalLesson();

    /**
     * @param int $totalLesson
     *
     * @return $this
     */
    public function setTotalLesson(int $totalLesson);

    /**
     * @return int
     */
    public function getCourseId();

    /**
     * @param int $courseId
     *
     * @return $this
     */
    public function setCourseId(int $courseId);

    /**
     * @return int
     */
    public function getTeacherId();

    /**
     * @param int $teacherId
     *
     * @return $this
     */
    public function setTeacherId(int $teacherId);
}
