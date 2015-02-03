<br/>
<h2 class="center">ALL FLIGHTS</h2>

<hr/>
<br/>  
<?php
$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" style="width:100%;text-align:center;">' );
$this->table->set_template($tmpl);

//And if the $site variable is not empty we echo it's content by using the generate method of the table class / library
if(!empty($flights)) echo $this->table->generate($flights); 

?>

