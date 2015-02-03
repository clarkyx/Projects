<br/>
<h2 class="center">AVAILABLE FLIGHTS</h2>

<hr/>
<br/>
<p>Please click on the book button in front of a flight to make a flight booking</p>
<br/>

<?php
$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" style="width:100%;text-align:center;">' );
$this->table->set_template($tmpl);

//And if the $site variable is not empty we echo it's content by using the generate method of the table class / library
if(!empty($flights)) echo $this->table->generate($flights); 

?>

<script type="text/javascript">
function book(id) {
	window.location = '<?php echo base_url(); ?>' + 'main/bookSeat/id/' + id;
}
</script>

