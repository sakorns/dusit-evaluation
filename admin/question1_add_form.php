<form id="form1" name="form1" method="post" action="question1_save_db.php" class="form-horizontal">
  <div class="form-group">
      <div class="col-sm-3"> ชื่อประเภทคำถาม </div>
      <div class="col-sm-7">
        <input type="text" name="qt_name" class="form-control"  required="required">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-3"> รายละเอียดคำถาม </div>
      <div class="col-sm-9">
        <input type="text" name="qt_detail" class="form-control"  required="required">
      </div>
    </div>
     <div class="form-group">
      <div class="col-sm-3">   </div>
      <div class="col-sm-6">
        <button type="submit" class="btn btn-primary"> บันทึก </button>
      </div>
    </div>
  </div>
</form>
