 <?php

include 'classes/MyFormValidator.php';

// Form Validation
//-----------------------------------------------------------
if(isset($_POST['frmName']) && $_POST['frmName']=='example'){
    
    $formVal = new FormValidator();
    $formVal->setMethod('POST');
    $formVal->registerFields();
    
    $formVal->validate('firstname')->clean()->isRequired();
    $formVal->validate('surname')->clean()->isRequired();
    $formVal->validate('emailadd')->clean()->isRequired()->isEmail();
    $formVal->validate('password')->clean()->isRequired()->isPassword();
    $formVal->validate('department')->isRequired();
    $formVal->validate('interests')->checkboxGroupRequired(2);
    
    $errors = $formVal->getErrors();
    $fields = $formVal->getFields();

} else {
    
    // Default Form Field Values
    // -------------------------
    $fields = array();
    $fields['firstname'] = '';
    $fields['surname'] = '';
    $fields['emailadd'] = '';
    $fields['password'] = '';
    $fields['department'] = '';
    $fields['interests'] = array();
    
    $errors = false;
    
}

?>


<pre style="background-color:#d6ffcc;padding: 10px; border: 1px dashed green;">
<?php var_dump($fields); ?>
</pre>

<pre style="background-color:#ffaeae;padding: 10px; border: 1px dashed red;">
<?php var_dump($errors); ?>
</pre>



<form action="" method="post">
    
    <table cellspacing="0" cellpadding="3">
        
        <tr>
            <th>First Name</th>
            <td><input name="firstname" id='firstname' type="text" value="<?=$fields['firstname'] ?>" /></td>
        </tr>
        
        <tr>
            <th>Surname</th>
            <td><input name="surname" id='surname' type="text" value="<?=$fields['surname'] ?>" /></td>
        </tr>
        
        <tr>
            <th>Email</th>
            <td><input name="emailadd" id='emailadd' type="text" value="<?=$fields['emailadd'] ?>" /></td>
        </tr>
        
        <tr>
            <th>Password</th>
            <td><input name="password" id='password' type="password" value="<?=$fields['password'] ?>" /></td>
        </tr>
        
        <tr>
            <th>Department</th>
            <td><select name='department' id='department'>
                    <option value=''>Select..</option>
                    <option value='HR'        <?=isset($fields['department']) && in_array('HR',        (array)$fields['department'])?'selected':''?>>HR</option>
                    <option value='IT'        <?=isset($fields['department']) && in_array('IT',        (array)$fields['department'])?'selected':''?>>IT</option>
                    <option value='Sales'     <?=isset($fields['department']) && in_array('Sales',     (array)$fields['department'])?'selected':''?>>Sales</option>
                    <option value='Marketing' <?=isset($fields['department']) && in_array('Marketing', (array)$fields['department'])?'selected':''?>>Marketing</option>
                </select>
            </td>
        </tr>

        <tr>
            <th>Interests</th>
            <td>
                <input type='checkbox' name='interests[]' value='PHP'   id='cb1' <?=isset($fields['interests']) && in_array('PHP',  (array)$fields['interests'])?'checked':''?> /> <label for='cb1'>PHP</label>
                <input type='checkbox' name='interests[]' value='MySQL' id='cb2' <?=isset($fields['interests']) && in_array('MySQL',(array)$fields['interests'])?'checked':''?> /> <label for='cb2'>MySQL</label>
                <input type='checkbox' name='interests[]' value='OOP'   id='cb3' <?=isset($fields['interests']) && in_array('OOP',  (array)$fields['interests'])?'checked':''?> /> <label for='cb3'>OOP</label>
                <span id='interests'><!-- ID for Error --></span>
            </td>
        </tr>
        
    </table>
    
    <input name="frmName" type="hidden" value="example"/>    
    <input name="" type="submit" value="Submit"/>    
    
</form>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
    <?php if($errors){ ?>
    <?php foreach($errors as $fieldName => $message){ ?>
    $("#<?=$fieldName ?>").after("<span style='color:red'><?=$message ?></span>");
    <?php } ?>
    <?php } ?>
});
</script>
