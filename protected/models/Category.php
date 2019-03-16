<?php

/**
 * This is the model class for table "nq_category".
 *
 * The followings are the available columns in table 'nq_category':
 * @property integer $id
 * @property string $category
 * @property string $category_discription
 * @property integer $parent_category
 * @property string $status
 * @property string $category_image
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $parent_category_value;
    public $category_banner;
	public function tableName()
	{
		return 'nq_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, created_at', 'required'),
			array('parent_category', 'numerical', 'integerOnly'=>true),
			array('category', 'length', 'max'=>530),
			array('status', 'length', 'max'=>1),
			array('category_image', 'length', 'max'=>250),
		    array('category','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category, category_discription, parent_category, status, category_image, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'category_discription' => 'Discription',
			'parent_category' => 'Parent Category',
			'status' => 'Status',
			'category_image' => 'Category Image',
		    'category_banner' => 'Category Banner (Size should be greater than 1500X700)',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('category_discription',$this->category_discription,true);
		$criteria->compare('parent_category',$this->parent_category);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('category_image',$this->category_image,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function CategoryDescription($data){
	    if(isset($data->category_discription) && $data->category_discription != "" )
	        $html = strlen($data->category_discription) > 20
	        ? CHtml::tag("span", array("title"=>$data->category_discription,"style"=>"color:#555555"), CHtml::encode(substr($data->category_discription, 0, 20)) . "...")
	        : CHtml::encode($data->category_discription)
	        ;
	        else
	            $html =  "";
	            return $html;
	}
	public function parentCategory($data){
	    $parent = "";
	    if($data->parent_category){
	        $parentData = self::model()->findByPk($data->parent_category);
	        $parent = $parentData->category;
	    }
	    return $parent;
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function CategoryLink($data){
	    //$parentExist = Category::model()->findByAttributes(array('parent_category'=>$data->id));
	    //if($data->status=="Y" && count($parentExist)>0){
	    if($data->status=="Y"){
	        echo "<a id=".$data->id." href=".Yii::app()->createUrl('category/CategoryList?parentId=' . $data->id).">".$data->category."</a>";
	    }else{
	        echo $data->category;
	    }
	}
	public function Switch_active_inactive($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<input type='checkbox' class='custom-switch' ".$status." name='$data->id'>";
	}
	
}
