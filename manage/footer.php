<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>


<script type="text/javascript">
      $(document).ready(function(){
        
        $('input#btnexport').live('click', function(){


          var excelName = $('input#excelName').val();
          
          if (excelName == '') {
            alert("What is the filename for excel?");
            //console.log("kosong");
            return false;
          } else {
            //console.log('ada isi');
            return true;
          }

          //console.log(excelName);

          //return false;
        });

      });
    </script>