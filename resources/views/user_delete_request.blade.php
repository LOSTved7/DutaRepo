<!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Description Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
    <style>
      #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
      }
  
      #modal {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
      }
  
      #okBtn {
      cursor: pointer;
      font-size: 18px;
      color: #333;
      padding: 8px 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 4px;
      margin-top: 10px;
      }
    </style>
    </head>
    <body>
    <img style="width: 210px; margin-top:10px; margin-left:35%" src="http://college.msell.in/public/images/app_logo/1.jpeg" alt="" width="110px" >
    <div class="col-sm-6 col-sm-offset-3">
      <h1>Deletion Request Form</h1>

      <form action="process.php" id="myForm" method="POST">
        <div id="name-group" class="form-group">
          <label for="name">Name <span style="color:read;">*</span></label>
          <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            required
            placeholder="Full Name"
          />
        </div>

        <div id="email-group" class="form-group">
          <label for="email">Email <span style="color:read;">*</span></label>
          <input
            type="text"
            class="form-control"
            id="email"
            name="email"
            required
            placeholder="email@example.com"
          />
        </div>

        <div id="superhero-group" class="form-group">
          <label for="superheroAlias">Company Name <span style="color:read;">*</span></label>
          <input
            type="text"
            class="form-control"
            id="companyName"
            name="companyName"
            required
            placeholder="Enter Company Name"
          />
        </div>
        <div id="superhero-group" class="form-group">
          <label for="superheroAlias">Description <span style="color:read;">*</span></label>
          <textarea type="text" required class="form-control"id="reason"name="reason"placeholder="Enter Your Reason"></textarea>
        </div>

        <button type="submit"  onclick="submitForm()" class="btn btn-success">
          Submit
        </button>
       
      </form>
      <div id="overlay">
        <div id="modal">
          <p>Form submitted successfully!</p>
          <span id="okBtn" onclick="closeModal()">OK</span>
        </div>
      </div>
    </div>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
      $("form").submit(function (event) {
        var formData = {
          name: $("#name").val(),
          email: $("#email").val(),
          companyName: $("#companyName").val(),
          reason: $("#reason").val(),
        };

        $.ajax({
          type: "POST",
          url: "process.php",
          data: formData,
          dataType: "json",
          encode: true,
        }).done(function (data) {
          // console.log(data);
            if(data){
                alert('Request Generated Succefully\nplease wait for next 48 Hours.')
            }
        });

        event.preventDefault();
      });
    });
</script>
<script>
  function submitForm() {
    // You can add form validation and submission logic here

    // Display the modal on successful form submission
    document.getElementById("overlay").style.display = "flex";
  }

  function closeModal() {
    // Close the modal and reset the form
    document.getElementById("overlay").style.display = "none";
    document.getElementById("myForm").reset();
  }
</script>
<script>
  function closeModal() {
    // Close the modal
    document.getElementById("overlay").style.display = "none";

    // Reset the form data
    document.getElementById("myForm").reset();
  }
</script>
</html>