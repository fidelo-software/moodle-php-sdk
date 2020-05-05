<?php

namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;
use MoodleSDK\Api\ModelCRUD;

class CourseCategory extends ModelBase implements ModelCRUD
{
	private $id;
	private $name;
	private $idnumber;
	private $description;
	private $parent;
	
	protected const FUNCTIONS_GET = 'core_course_get_categories';
	protected const FUNCTIONS_GET_BY_FIELD = null;

	public function get(ApiContext $apiContext) {
		;
	}
	
	public function findOneById(ApiContext $apiContext, $id)
    {
        $json = $this->apiCall($apiContext, self::FUNCTIONS_GET, [
			'criteria' => [
				[
					'key' => 'id',
					'value' => (int)$id
				]
			]
		]);

        $results = json_decode($json);

		if(empty($results)) {
			return;
		}

        $this->fromObject($results[0]);

        return $this;
    }
	
	public function findOneByIdNumber(ApiContext $apiContext, $idnumber) 
	{

		$json = $this->apiCall($apiContext, self::FUNCTIONS_GET, [
			'criteria' => [
				[
					'key' => 'idnumber',
					'value' => $idnumber
				]
			]
		]);

        $results = json_decode($json);

		if(empty($results)) {
			return;
		}

        $this->fromObject($results[0]);

        return $this;	
	}
	
	public function findOneByName(ApiContext $apiContext, $name) 
	{

		$json = $this->apiCall($apiContext, self::FUNCTIONS_GET, [
			'criteria' => [
				[
					'key' => 'name',
					'value' => $name
				]
			]
		]);

        $results = json_decode($json);

		if(empty($results)) {
			return;
		}

        $this->fromObject($results[0]);

        return $this;	
	}
	
	public function create(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_create_categories', [
            'categories' => [
                $this->toArray()
            ]
        ]);

		$results = json_decode($json, true);
		
        return $results[0];
    }

    public function update(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_update_categories', [
            'categories' => [
                $this->toArray()
            ]
        ]);

        return $json;
    }

    public function delete(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_delete_categories', [
            'categories' => [
				[
					'id' => $this->getId()
				]
				
			]
        ]);

        return $json;
    }
	
	
    // Properties Getters & Setters

	/**
	 * @return int
	 */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @param int $id
	 * @return $this
	 */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdnumber()
    {
        return $this->idnumber;
    }

    /**
     * @param mixed $idnumber
     */
    public function setIdnumber($idnumber)
    {
        $this->idnumber = $idnumber;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * @param string $name
	 * @return $this
	 */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
	 * @return int
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * @param int $parent
	 * @return $this
	 */
	public function setParent($parent) 
	{
		$this->parent = $parent;
		return $this;
	}
	
}
