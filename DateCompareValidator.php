<?php
  /**
   * Date Compare Validator
   * 
   * @author Frank He <frankhe.cn@gmail.com>
   */
  class DateCompareValidator extends CDateValidator
  {
    /** minimum date */
    public $min = null;

    /** maxmimum date */
    public $max = null;

    /**
     * validate date first, and ensure the date does not be earlier than $min and no later than $max
     * @param object data model
     * @param string data model attributes
     *
     */
    protected function validateAttribute($object, $attribute)
    {
      $value = $object->$attribute;
      if($this->allowEmpty && $this->isEmpty($value))
        return;

      parent::validateAttribute($object, $attribute);

      // reason of array checking is explained here: https://github.com/yiisoft/yii/issues/1955
      if(!is_array($value))
      {
        $formats=is_string($this->format) ? array($this->format) : $this->format;


        foreach($formats as $format)
        {
          $timestamp=CDateTimeParser::parse($value,$format,array('month'=>1,'day'=>1,'hour'=>0,'minute'=>0,'second'=>0));
          if($timestamp!==false)
          {
            $timestamp_min = 0; $timestamp_max=0;
            if (!empty($this->min))
              $timestamp_min=CDateTimeParser::parse($this->min,$format,array('month'=>1,'day'=>1,'hour'=>0,'minute'=>0,'second'=>0));
            if (!empty($this->max))
              $timestamp_max=CDateTimeParser::parse($this->max,$format,array('month'=>1,'day'=>1,'hour'=>0,'minute'=>0,'second'=>0));

            if ($timestamp_min>0 && $timestamp_min>$timestamp)
            {
              $message=$this->message!==null ? $this->message : Yii::t('yii', '{attribute} must not be earlier than "{min}".', array('{min}'=>$this->min));
              $this->addError($object,$attribute,$message);
            }
            if ($timestamp_max>0 && $timestamp_max<$timestamp)
            {
              $message=$this->message!==null ? $this->message : Yii::t('yii', '{attribute} must not be later than "{max}".', array('{max}'=>$this->max));
              $this->addError($object,$attribute,$message);
            }
            break;
          }
        }
      }
    }
  }
?>