 <?php
/**
 * MyFormValidator Class.
 *
 * @category  Form Validation
 *
 * @author    Chris Maggs <git@maggsweb.co.uk>
 * @copyright Copyright (c)2018
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 *
 * @version   1.1
 **/
 
class FormValidator {
    
    private $method,
            $field,
            $errors = array(),
            $fields = array();
        
    public function __construct($method = 'GET')
    {
        // Default 'form method'
        $this->method = $_GET;
        
        if(trim(strtolower($method)) == 'post'){
            $this->method = $_POST;
        }
        
        $this->_registerFields();
        
    }
    
    // PRIVATE METHODS  /////////////////////////////////////////////////////////////////
    
    
    /**
     * @desc Store all submitted fields on:
     * $this->fields;
     */
    private function _registerFields()
    {
        if(is_array($this->method)){
            foreach($this->method as $key => $tmp){
                if(is_array($tmp)){
                    $this->fields[$key] = array();
                } else {
                    if(isset($this->fields[$key])){
                        $this->fields[$key] = $this->method[$tmp];
                    } else {
                        $this->fields[$key] = '';
                    }
                }
            }
        }
        //var_dump($this->fields);
    }
    
    
    // PUBLIC METHODS  /////////////////////////////////////////////////////////////////
    
    /**
     * @desc Return an array of errors for processing
     * @return type
     */
    public function getErrors()
    {
        return $this->errors;
    }

    
    /**
     * @desc Return an array of validated fields for processing
     * @return type
     */
    public function getFields()
    {
        return $this->fields;
    }


    /**
     * 
     * @param type $field
     * @return $this
     */
    public function validate($field)
    {       
        // Set original value on $this->fields
        if(isset($this->fields[$field])){
            $this->fields[$field] = $this->method[$field];
        }
        
        // Set fieldname for further validation
        $this->field = $field;
        return $this;
    }

    
    ///////////////////////////////////////////////////////////////////////////////////////////
    //  Additional Validation Methods   ///////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    
    /**
     * 
     * @return $this
     */
    public function clean()
    {
        if(isset($this->method[$this->field])){
            
            // Sanitise field
            $cleanInput = $this->method[$this->field];
            $cleanInput = trim($cleanInput);
            $cleanInput = filter_var($cleanInput,FILTER_SANITIZE_STRING);
            
            // Overwrite with clean value
            $this->fields[$this->field] = $cleanInput;
        }
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isRequired()
    {       
        if(isset($this->method[$this->field])){
            if(! strlen($this->method[$this->field])){
                $this->errors[$this->field] = 'This field is required';
            }
        } else {
            $this->errors[$this->field] = 'This field is required';
        }
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isEmail()
    {
        if(isset($this->method[$this->field])){
            $EMAIL = filter_var($this->fields[$this->field], FILTER_SANITIZE_EMAIL);
            if(filter_var($EMAIL, FILTER_VALIDATE_EMAIL) === false){
                $this->errors[$this->field] = 'Email address is invalid';
            }
        }
        $this->fields[$this->field] = strtolower($EMAIL);
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isURL()
    {
        if(isset($this->method[$this->field])){
            $URL = filter_var($this->fields[$this->field], FILTER_SANITIZE_URL);
            if(filter_var($URL, FILTER_VALIDATE_URL) === false){
                $this->errors[$this->field] = 'URL is invalid';
            }
        }
        $this->fields[$this->field] = strtolower($URL);
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isNumber($withinRange = false)
    {
        if(isset($this->method[$this->field])){
            
            $NUMBER = $this->fields[$this->field];
            
            // Integer
            if (!(filter_var($NUMBER, FILTER_VALIDATE_INT) === 0 || filter_var($NUMBER, FILTER_VALIDATE_INT))) {
                $this->errors[$this->field] = 'Value is not numeric';
                return $this;
            }

            // Range
            if(is_array($withinRange)){
                list($min,$max) = $withinRange;
                if (filter_var($NUMBER, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
                    $this->errors[$this->field] = "Value is not with the range of $min - $max";
                }
            }
        }
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isPassword($minChar=6, $maxChar=20, $forceUpperCase = false)
    {
        if($maxChar <= $minChar){
            $maxChar = $minChar + 6;
        }
        
        if(isset($this->method[$this->field])){
            if(strlen($this->fields[$this->field]) < $minChar){
                $this->errors[$this->field] = "Passwords must be more than $minChar characters";
                return $this;
            }
            if(strlen($this->fields[$this->field]) > $maxChar){
                $this->errors[$this->field] = "Passwords must be less than $maxChar characters";
                return $this;
            }
            if($forceUpperCase){
                if(!preg_match('/[A-Z]+/',$this->fields[$this->field])){
                    $this->errors[$this->field] = "Passwords must contain an uppercase charcacter";
                    return $this;
                }
            }
        }
        return $this;
    }
    
    
    /**
     * 
     * @param type $requiredSelections
     * @return $this
     */
    public function checkboxGroupRequired($requiredSelections=1)
    {
        if(isset($this->method[$this->field])){
            if(is_array($this->method[$this->field])){
                if(count($this->method[$this->field]) < $requiredSelections){
                    $this->errors[$this->field] = 'You must select '.$requiredSelections.' options';
                }
            }
        } else {
            $this->errors[$this->field] = 'You must select '.$requiredSelections.' options';
        }
        return $this;
    }
    
    
}
    
    
    
    
    
    
    
