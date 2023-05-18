$(document).ready(function() {


    $('#values').on('change',function() {
      var nums =this.value;
      var auctionStatus=$('#auction-status option:selected').val();
      $.ajax({
        url: "auctions.php",
        type: "POST",
        data: {
          num: nums ,
          status:auctionStatus,
        }
      });
    });
  });

  $(document).ready(function() {

  $('#auction-status ').on('change',function() {
      var nums = $('#values option:selected').val();
      var auctionStatus = this.value;
      $.ajax({
        url: "auctions.php",
        type: "POST",
        data: {
          num: nums ,
          status:auctionStatus,
        }
      });
    });

  });