DateCompareValidator for Yii
============================
This extension validate a date and ensure it is between min and max date if set

##Requirements
This extension has been tested with Yii Framework 1.1.14

##Usage
Place the extension in your protected\extensions directory and add it to your model like the following:

public function rules()
{
    return array(
		array('expiry', 'ext.DateCompareValidator', 'allowEmpty'=>true, 'format'=>'dd/MM/yyyy', 'min'=>date('d/m/Y'), 'max'=>'01/01/2014'),
	);
}
