<style>
  .wrapper{
    display:grid;
    grid-template-columns:1fr 1fr;
    grid-auto-rows:minmax(20px, auto);
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
    padding:2em;
  }

  .top{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:2em;
    height: 10px;
  }
  .top_left{
    align-self:left;
    grid-column:1/5;
    text-align: left;
    padding:2em;
    height: 10px;
  }

  .bottom_center{
    align-self:center;
    grid-column:1/3;
    text-align:left;
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .announce{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:1em;
  }

  .left{
    /*justify-self:end;*/
    grid-column:1/2;
    padding-right:1em;
    /* grid-row:3; */
    /* border:1px solid #333; */
  }

  .right{
    grid-column:2/3;
    padding-left:1em;
    /* grid-row:2/4; */
    /* border:1px solid #333; */
  }

</style>


<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="top">
      <h5><u><?= $title ?></u></h5>
    </div>
    
    <form class="user" method="post" action="<?= base_url('Event_CRUD/add_proses'); ?>">
      <div class="wrapper">
        <div class="left">
          <label for="event_nama"><b><u>Event Name:</u></b></label>
          <input name="event_nama" type="text" class="form-control form-control-sm" required>
        </div>
        <div class="right">
          <label for="event_tgl"><b><u>Event Date:</u></b></label>
          <input name="event_tgl" type="date" class="form-control form-control-sm" required>
        </div>
        <div class="bottom_center">
          <button type="submit" class="btn btn-primary btn-user btn-block">
            Add
          </button>
        </div>
      </div>
    </form>

  </div>
</div>