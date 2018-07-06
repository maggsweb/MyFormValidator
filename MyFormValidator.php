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
        
    public function __construct()
    {
        // Default 'form method'
        $this->method = $_GET;
    }

    
    /**
     * @desc optional method to set 'form method' to POST
     * @param type $method
     */
    public function setMethod($method)
    {
        if($method == 'post'||$method == 'POST'){
            $this->method = $_POST;
        }
    }
    
    
    /**
     * @desc Store all submitted fields on:
     * $this->fields;
     */
    public function registerFields(){
        if(is_array($this->method)){
            foreach($this->method as $key => $tmp){
                if(is_array($tmp)){
                    $this->fields[$key] = array();
                } else {
                    if(isset($this->fields[$key])){
                        $this->fields[$key] = $this->method[$tmp];
                    }
                }
            }
        }
    }
    
    
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
            if(! filter_var($this->fields[$this->field], FILTER_VALIDATE_EMAIL)){
                $this->errors[$this->field] = 'Email address is invalid';
            }
        }
        return $this;
    }
    
    
    /**
     * 
     * @return $this
     */
    public function isPassword()
    {
        if(isset($this->method[$this->field])){
            if(strlen($this->fields[$this->field]) < 6){
                $this->errors[$this->field] = 'Password must be 6 characters';
            }
            if(strlen($this->fields[$this->field]) > 20){
                $this->errors[$this->field] = 'Password must be less than 20 characters';
            }
        }
        return $this;
    }
    
    
    /**
     * 
     * @param type $requiredSelections
     * @return $this
     */
    public function checkboxGroupRequired($requiredSelections=1){
        if(isset($this->method[$this->field])){
            if(is_array($this->method[$this->field])){
                if(count($this->method[$this->field]) < $requiredSelections){
                    $this->errors[$this->field] = 'You must select '.$requiredSelections.' options';
                }
            }
        } else {
            $this->errors[$this->field] = 'You must make selections';
        }
        return $this;
    }
    
    
}
    
    
    
    
    
    
    
