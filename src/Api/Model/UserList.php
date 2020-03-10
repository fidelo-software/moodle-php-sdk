<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class UserList extends ModelBaseList
{

    public function all(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_user_get_users', [
            'criteria' => [
                [
                    'key' => 'string',
                    'value' => 'string'
                ]
            ]
        ]);

        /**
         * Workaround: core_user_get_users returns an array with two keys "users" and "warnings",
         * which is incompatible to fromJSON
         */
        $result = json_decode($json);

        $this->fromJSON(json_encode($result->users));
        return $this;
    }

    /**
     * Find users by Ids
     *
     * @param ApiContext $apiContext
     * @param array $courseIds
     * @param string $fieldName
     * @return $this
     */
    public function findByIds(ApiContext $apiContext, array $userIds, $fieldName = 'id')
    {
        $data = [];

        /**
         * The Moodle API doesn't accept data by payload, but only by request argument
         * Therefore the maximum Request URI size matters and we must split fetching the data
         * in multiple requests
         */
        $chunkedUserIds = array_chunk($userIds, 100);
        foreach ($chunkedUserIds as $userIdArray) {

            $json = $this->apiCall($apiContext, 'core_user_get_users_by_field', [
                'field' => $fieldName,
                'values' => $userIdArray
            ]);
            $data = array_merge($data, json_decode($json, true));
        }

        $json = json_encode($data);

        $this->fromJSON($json);
        return $this;
    }

}