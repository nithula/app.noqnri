<?php

/**
 * This is the model class for table "nq_formula".
 *
 * The followings are the available columns in table 'nq_formula':
 * @property integer $id
 * @property integer $partner_id
 * @property string $formula
 * @property string $description
 * @property string $status
 * @property string $created_at
 */
class Formula extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nq_formula';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_id, formula, description, created_at', 'required'),
			array('partner_id', 'numerical', 'integerOnly'=>true),
			array('formula', 'length', 'max'=>150),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, partner_id, formula, description, status, created_at', 'safe', 'on'=>'search'),
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
			'partner_id' => 'Partner',
			'formula' => 'Formula',
			'description' => 'Description',
			'status' => 'Y=Active,N=Inactive',
			'created_at' => 'Created At',
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
		$criteria->compare('partner_id',$this->partner_id);
		$criteria->compare('formula',$this->formula,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Formula the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function IDData($data){
	    $trasactionData = Transaction::model()->findAllByAttributes(array('points_reference'=>$data->id));
	    if(count($trasactionData)>0){
	        echo $data->id;
	    }else{
	        echo $data->id.' <a href="javascript:void(0)" id='.$data->id.' class="specialClass" style="font-size:20px"><span class="show_'.$data->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span><span class="hidden_'.$data->id.'" style="display:none;"><i class="fa fa-check" aria-hidden="true" id='.$data->id.'></i></span></a>';
	    }
	}
	public function CreatedDate($data) {
	    $date       = $data->created_at;
	    $date       = Common::getTimezone($date,'d M y - h: i a');
	    echo $date;
	}
	public function DescriptionData($data){
	    if(isset($data->description) && $data->description != "" )
	        $html = strlen($data->description) > 12
	        ? CHtml::tag("span", array("title"=>$data->description,"style"=>"color:#555555"), CHtml::encode(substr($data->description, 0, 12)) . "...")
	        : CHtml::encode($data->description)
	        ;
	        else
	            $html =  "";
	            echo '<a href="javascript:void(0)" id='.$data->id.' class="specialInputClass"><span class="showInput_'.$data->id.'" id="textArea_'.$data->id.'">'.$html.'</span><span class="hiddenInput_'.$data->id.'" style="display:none;"><textarea class="form-control" placeholder="Description" data-validation="required" name="Formula[description]" id="Formula_description_'.$data->id.'">'.$data->description.'</textarea></span></a>';
	}
	public function FormulaData($data){
	    echo '<a href="javascript:void(0)" id='.$data->id.' class="specialInputClass"><span class="showInput_'.$data->id.'" id="textfield_'.$data->id.'">'.$data->formula.'</span><span class="hiddenInput_'.$data->id.'" style="display:none;"><input class="form-control" maxlength="16" placeholder="Formula" autocomplete="off" data-validation="required" name="Formula[formula]" id="Formula_formula_'.$data->id.'" type="text" value='.$data->formula.'></span></a>';
	}
	public function Switch_active_inactive($data){
	    $status = ($data->status=='Y')?'checked':'';
	    echo "<label class='switch'><input type='radio' class='change_status' name='status' $status id='$data->id'><span class='slider round'></span></label>";
	}
}
