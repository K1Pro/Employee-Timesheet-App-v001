<form id="ContactFields">
  <div class="input-group">
    <img src="images/BundleWhite.png" alt="Bundle" />
  </div>
  <br />
  <!-- <input
    type="text"
    placeholder="Contact ID"
    class="form-control"
    id="id"
    disabled
  /> -->
  <?php
  echo "Selected Date: " . date('l', strtotime($date)) . " " . $date;
    listAllNodeActivity($sidePanelDate, $nodeList);
  ?>
</form>
<div id="SidePanelHTMLModule"></div>
