<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class CourseList extends ModelBaseList
{

    /**
     * Fetch all courses
     *
     * @param ApiContext $apiContext
     * @return $this
     */
    public function all(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => [
                ]
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    /**
     * Fetch all courses with contents
     *
     * @param ApiContext $apiContext
     * @return $this
     */
    public function allWithContents(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => [
                ]
            ]
        ]);

        $courses = json_decode($json);
        $courseIds = [];
        foreach ($courses as $course) {
            $courseIds[] = $course->id;
        }

        return $this->findWithContentsByIds($apiContext, $courseIds);
    }

    /**
     * Find courses by Ids
     *
     * @param ApiContext $apiContext
     * @param array $courseIds
     * @return $this
     */
    public function findByIds(ApiContext $apiContext, array $courseIds)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => $courseIds
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    /**
     * Find courses with contents by Ids
     *
     * @param ApiContext $apiContext
     * @param array $courseIds
     * @return $this
     */
    public function findWithContentsByIds(ApiContext $apiContext, array $courseIds)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses_by_field', [
            'field' => 'ids',
            'value' => implode(',', $courseIds)
        ]);

        $data = json_decode($json); // courses:[], warnings: []

        foreach ($data->courses as $itemData) {
            $item = new Course();
            $item->fromArray($itemData);

            $this->list[] = $item;
            $this->rawData[] = (array)$itemData;
        }

        return $this;
    }

    public function searchByUser(ApiContext $apiContext, User $user)
    {
        $json = $this->apiCall($apiContext, 'core_enrol_get_users_courses', [
            'userid' => $user->getId()
        ]);

        $this->fromJSON($json);
        return $this;
    }

    public function bulkUpdate(ApiContext $apiContext, array $coursesToUpdate)
    {
        $json = $this->apiCall($apiContext, 'core_course_update_courses', [
            'courses' => $coursesToUpdate
        ]);
        return $json;
    }

    public function bulkDelete(ApiContext $apiContext, array $idsOfCoursesToDelete)
    {
        $json = $this->apiCall($apiContext, 'core_course_delete_courses', [
            'courseids' => $idsOfCoursesToDelete
        ]);
        return $json;
    }
}
