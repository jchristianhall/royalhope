// @codekit-prepend "bootstrap.js";
$(document).ready(function(){

  // Variables
  var state = "opening";
  var addType = "";
  var listType = "";
  var searchType = "";
  var currentID = "";

  /** Validation functions */
  function alert(message, type)
  {
    var error = "";
    if (type === 'warning')
    {
      error += "<div class='alert fade in'>";
    }
    else
    {
      error += "<div class='alert alert-error fade in'>";
    }
    error += "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
    error += "<strong>Alert!</strong>" + message;
    error += "</div>";

    $('.container').append(error);
  }

  // Add error styles to blank fields
  function checkBlankField(field)
  {
    if($(field).val() === "")
    {
      $(field).parent('.controls').parent('.control-group').addClass('error');
      $(field).parent('.controls').children('.help-inline').remove();
      $(field).parent('.controls').append('<span class="help-inline">Required input</span>');
      return false;
    }
    else
    {
      return true;
    }
  }

  // Add error styles to invalid fields
  function alertField(field, message)
  {
    $(field).parent('.controls').parent('.control-group').addClass('error');
    $(field).parent('.controls').children('.help-inline').remove();
    $(field).parent('.controls').append('<span class="help-inline">' + message + '</span>');
  }

  // Remove error styles on focus
  $('input').focus(
    function()
    {
      $(this).parent('.controls').parent('.control-group').removeClass('error');
      $(this).parent('.controls').children('.help-inline').remove();
    }
  );

  // Check each input on the doctor form and return true if valid
  function validateDoctor()
  {
    var firstCheck = checkBlankField('#doctorFirst');
    var lastCheck = checkBlankField('#doctorLast');
    var ssnCheck = checkBlankField('#doctorssn');
    var addressCheck = checkBlankField('#doctorAddress');
    var phoneCheck = checkBlankField('#doctorPhone');
    var birthCheck = checkBlankField('#doctorBirth');
    var salaryCheck = checkBlankField('#doctorSalary');
    var specialtyCheck = checkBlankField('#doctorSpecialty');
    if (firstCheck && lastCheck && ssnCheck && addressCheck &&
        phoneCheck && birthCheck && salaryCheck && specialtyCheck)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  // Check each input on the patient form and return true if valid
  function validatePatient()
  {
    var firstCheck = checkBlankField('#patientFirst');
    var lastCheck = checkBlankField('#patientLast');
    var ssnCheck = checkBlankField('#patientssn');
    var addressCheck = checkBlankField('#patientAddress');
    var phoneCheck = checkBlankField('#patientPhone');
    var birthCheck = checkBlankField('#patientBirth');
    var billCheck = checkBlankField('#patientBill');
    var admitCheck = checkBlankField('#patientAdmit');
    var doctorCheck = checkBlankField('#patientDoctor');
    if (firstCheck && lastCheck && ssnCheck && addressCheck &&
        phoneCheck && birthCheck && billCheck && admitCheck &&
        doctorCheck)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  /** Opening click events */
  $('.add').click
  (
    function()
    {
      if (state === "opening")
      {
        $('#opening').fadeOut('fast');
      }
      else if (state === "list")
      {
        $('#listView').fadeOut('fast');
      }
      else if (state === "search")
      {
        $('#searchView').fadeOut('fast');
      }
      else if (state === "profile")
      {
        $('#profileView').fadeOut('fast').empty();
      }
      else if (state === "edit")
      {
        $('#editView').fadeOut('fast').empty();
      }
      $('#addView').delay(500).fadeIn('fast');
      state = "add";
    }
  );
  $('.list').click
  (
    function()
    {
      if (state === "opening")
      {
        $('#opening').fadeOut('fast');
      }
      else if (state === "add")
      {
        $('#addView').fadeOut('fast');
      }
      else if (state === "search")
      {
        $('#searchView').fadeOut('fast');
      }
      else if (state === "profile")
      {
        $('#profileView').fadeOut('fast').empty();
      }
      else if (state === "edit")
      {
        $('#editView').fadeOut('fast').empty();
      }
      $('#listView').delay(500).fadeIn('fast');
      state = "list";
    }
  );
  $('.search').click
  (
    function()
    {
      if (state === "opening")
      {
        $('#opening').fadeOut('fast');
      }
      else if (state === "list")
      {
        $('#listView').fadeOut('fast');
      }
      else if (state === "add")
      {
        $('#addView').fadeOut('fast');
      }
      else if (state === "profile")
      {
        $('#profileView').fadeOut('fast').empty();
      }
      else if (state === "edit")
      {
        $('#editView').fadeOut('fast').empty();
      }
      $('#searchView').delay(500).fadeIn('fast');
      state = "search";
    }
  );

  /** Add section scripts */
  $('#doctorToggle').click
  (
    function()
    {
      if (addType === "")
      {
        $('#doctorForm').fadeIn('fast');
      }
      else
      {
        $('#patientForm').fadeOut('fast');
        $('#doctorForm').delay(500).fadeIn('fast');
      }
      addType = "Doctor";
    }
  );
  $('#patientToggle').click
  (
    function()
    {
      if (addType === "")
      {
        $('#patientForm').fadeIn('fast');
      }
      else
      {
        $('#doctorForm').fadeOut('fast');
        $('#patientForm').delay(500).fadeIn('fast');
      }
      addType = "Patient";
    }
  );

  // AJAX functions
  function addDoctor(event)
  {
    event.preventDefault();

    if (validateDoctor())
    {
      // Send a post request with the form data
      var form = $("#doctorForm").serialize();
      var url = $("#doctorForm").attr('action');
      $.post(url, form,
        function(data)
        {
          var message = "Invalid input";
          if (data === "invalidFirst")
          {
            alertField("#doctorFirst", message);
          }
          else if (data === "invalidLast")
          {
            alertField("#doctorLast", message);
          }
          else if (data === "invalidSSN")
          {
            alertField("#doctorssn", message);
          }
          else if (data === "duplicateSSN")
          {
            alertField("#doctorssn", "User already exists");
          }
          else if (data === "invalidPhone")
          {
            alertField("#doctorPhone", message);
          }
          else if (data === "invalidBirth")
          {
            alertField("#doctorBirth", message);
          }
          else if (data === "invalidSalary")
          {
            alertField("#doctorSalary", message);
          }
          else if (data === "invalidSpecialty")
          {
            alertField("#doctorSpecialty", message);
          }
          else if (data === "success")
          {
            // Reload page if php file returns success
            window.location.reload();
          }
          else
          {
            alert('Something went wrong', 'error');
          }
        }
      );
    }
  }
  function addPatient(event)
  {
    event.preventDefault();

    if (validatePatient())
    {
      // Send a post request with the form data
      var form = $("#patientForm").serialize();
      var url = $("#patientForm").attr('action');
      $.post(url, form,
        function(data)
        {
          var message = "Invalid input";
          if (data === "invalidFirst")
          {
            alertField("#patientFirst", message);
          }
          else if (data === "invalidLast")
          {
            alertField("#patientLast", message);
          }
          else if (data === "invalidSSN")
          {
            alertField("#patientssn", message);
          }
          else if (data === "duplicateSSN")
          {
            alertField("#patientssn", "User already exists");
          }
          else if (data === "invalidPhone")
          {
            alertField("#patientPhone", message);
          }
          else if (data === "invalidBirth")
          {
            alertField("#patientBirth", message);
          }
          else if (data === "invalidBill")
          {
            alertField("#patientBill", message);
          }
          else if (data === "invalidIllness")
          {
            alertField("#patientIllness", message);
          }
          else if (data === "invalidAdmit")
          {
            alertField("#patientAdmit", message);
          }
          else if (data === "invalidDoctor")
          {
            alertField("#patientDoctor", message);
          }
          else if (data === "success")
          {
            // Reload page if php file returns success
            window.location.reload();
          }
          else
          {
            alert(data, 'error');
          }
        }
      );
    }
  }

  // Sniffer for Doctor form submit
  $("#doctorForm").submit(addDoctor);

  // Sniffer for Patient form submit
  $("#patientForm").submit(addPatient);

  /** List section scripts */

  // Sniffer for List select
  $("#listSelect").change(
    function()
    {
      var selection = $(this).val();
      if (selection === "All Doctors")
      {
        $("#listResults").empty().load("php/listDoctors.php");
        listType = "Doctor";
      }
      else if (selection === "Diagnosed Patients")
      {
        $("#listResults").empty().load("php/listPatients.php", {type : "diagnosed"});
        listType = "Patient";
      }
      else if (selection === "Undiagnosed Patients")
      {
        $("#listResults").empty().load("php/listPatients.php", {type : "undiagnosed"});
        listType = "Patient";
      }
      else if (selection === "Released Patients")
      {
        $("#listResults").empty().load("php/listPatients.php", {type : "released"});
        listType = "Patient";
      }
      else
      {
        $("#listResults").empty();
      }
    }
  );

  /** Search section scripts */

  // AJAX function
  function searchSubmit(event)
  {
    event.preventDefault();

    // Get value from search bar
    var search = $("#searchBar").val();
    var form = {searchBar : search};

    // Empty field checks
    if (searchType === "")
    {
      alert("Select a search type", 'warning');
    }
    if (search === "")
    {
      alert("No input detected", 'warning');
    }

    // Construct post request based on search bar and type
    else if (searchType === "Specialty")
    {
      $("#searchResults").empty().load("php/searchSpecialty.php", form);
      $('.alert').alert('close');
    }
    else if (searchType === "Illness")
    {
      $("#searchResults").empty().load("php/searchIllness.php", form);
      $('.alert').alert('close');
    }
  }

  // Sniffer for Search Specialty
  $("#searchSpecialty").click
  (
    function()
    {
      $("#searchDropdown").button('s');
      searchType = "Specialty";
    }
  );

  // Sniffer for Search Illness
  $("#searchIllness").click
  (
    function()
    {
      $("#searchDropdown").button('i');
      searchType = "Illness";
    }
  );

  // Sniffer for Search submit
  $("#searchForm").submit(searchSubmit);

  /** Profile section scripts */

  // AJAX function
  function buildProfile()
  {
    // Determine what type of person
    var form = {};
    if (listType === "Doctor" || searchType === "Specialty")
    {
      form = {personID : currentID};

      // Load script that builds profile for doctor
      $("#profileView").empty().load("php/profileDoctor.php", form);
    }
    else if (listType === "Patient" || searchType === "Illness")
    {
      form = {personID : currentID};

      // Load script that builds profile for patient
      $("#profileView").empty().load("php/profilePatient.php", form);
    }
  }

  // Sniffer for listItem select
  $('#listResults').on('click', '.listItem', function()
  {
    // Get person ID
    currentID = this.id;

    // Add HTML string
    buildProfile(currentID);

    // Change to profile view and update state
    $('#listView').fadeOut('fast');
    $('#profileView').delay(500).fadeIn('fast');
    state = "profile";
  });

  // Sniffer for searchItem select
  $('#searchResults').on('click', '.searchItem', function()
  {
    // Get person ID
    currentID = this.id;

    // Add HTML string
    buildProfile();

    // Change to profile view and update state
    $('#searchView').fadeOut('fast');
    $('#profileView').delay(500).fadeIn('fast');
    state = "profile";
  });

  /** Edit section scripts */

  // Check each input on the edit doctor form and return true if valid
  function validateUpdateDoctor()
  {
    var firstCheck = checkBlankField('#editDoctorFirst');
    var lastCheck = checkBlankField('#editDoctorLast');
    var addressCheck = checkBlankField('#editDoctorAddress');
    var phoneCheck = checkBlankField('#editDoctorPhone');
    var birthCheck = checkBlankField('#editDoctorBirth');
    var salaryCheck = checkBlankField('#editDoctorSalary');
    var specialtyCheck = checkBlankField('#editDoctorSpecialty');
    if (firstCheck && lastCheck && addressCheck && phoneCheck &&
        birthCheck && salaryCheck && specialtyCheck)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  // Check each input on the edit patient form and return true if valid
  function validateUpdatePatient()
  {
    var firstCheck = checkBlankField('#editPatientFirst');
    var lastCheck = checkBlankField('#editPatientLast');
    var addressCheck = checkBlankField('#editPatientAddress');
    var phoneCheck = checkBlankField('#editPatientPhone');
    var birthCheck = checkBlankField('#editPatientBirth');
    var billCheck = checkBlankField('#editPatientBill');
    var admitCheck = checkBlankField('#editPatientAdmit');
    var doctorCheck = checkBlankField('#editPatientDoctor');
    if (firstCheck && lastCheck && addressCheck && phoneCheck &&
        birthCheck && billCheck && admitCheck && doctorCheck)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  // AJAX functions
  function updateDoctor(event)
  {
    event.preventDefault();

    if (validateUpdateDoctor())
    {
      // Send a post request with the form data
      var form = $("#editDoctorForm").serialize();
      form += "&editDoctorssn=" + $("#editDoctorssn").val();
      var url = $("#editDoctorForm").attr('action');
      $.post(url, form,
        function(data)
        {
          var message = "Invalid input";
          if (data === "invalidFirst")
          {
            alertField("#editDoctorFirst", message);
          }
          else if (data === "invalidLast")
          {
            alertField("#editDoctorLast", message);
          }
          else if (data === "invalidPhone")
          {
            alertField("#editDoctorPhone", message);
          }
          else if (data === "invalidBirth")
          {
            alertField("#editDoctorBirth", message);
          }
          else if (data === "invalidSalary")
          {
            alertField("#editDoctorSalary", message);
          }
          else if (data === "invalidSpecialty")
          {
            alertField("#editDoctorSpecialty", message);
          }
          else if (data === "success")
          {
            // Reload page if php file returns success
            window.location.reload();
          }
          else
          {
            alert('Something went wrong', 'error');
          }
        }
      );
    }
  }

  function updatePatient(event)
  {
    event.preventDefault();

    if (validateUpdatePatient())
    {
      // Send a post request with the form data
      var form = $("#editPatientForm").serialize();
      form += "&editPatientssn=" + $("#editPatientssn").val();
      var url = $("#editPatientForm").attr('action');
      $.post(url, form,
        function(data)
        {
          var message = "Invalid input";
          if (data === "invalidFirst")
          {
            alertField("#editPatientFirst", message);
          }
          else if (data === "invalidLast")
          {
            alertField("#editPatientLast", message);
          }
          else if (data === "invalidPhone")
          {
            alertField("#editPatientPhone", message);
          }
          else if (data === "invalidBirth")
          {
            alertField("#editPatientBirth", message);
          }
          else if (data === "invalidBill")
          {
            alertField("#editPatientBill", message);
          }
          else if (data === "invalidIllness")
          {
            alertField("#editPatientIllness", message);
          }
          else if (data === "invalidAdmit")
          {
            alertField("#editPatientAdmit", message);
          }
          else if (data === "invalidDoctor")
          {
            alertField("#editPatientDoctor", message);
          }
          else if (data === "success")
          {
            // Reload page if php file returns success
            window.location.reload();
          }
          else
          {
            alert('Something went wrong', 'error');
          }
        }
      );
    }
  }

  // Sniffer for profile edit for doctor button click
  $('#profileView').on('click', '.profileEditDoctorButton', function()
  {
    // Load script that builds edit page for doctor
    $("#editView").empty().load("php/editDoctor.php", {personID : currentID});

    // Change to edit view and update the state
    $('#profileView').fadeOut('fast');
    $('#editView').delay(500).fadeIn('fast');
    state = "edit";
  });

  // Sniffer for profile edit for patient button click
  $('#profileView').on('click', '.profileEditPatientButton', function()
  {
    // Load script that builds edit page for doctor
    $("#editView").empty().load("php/editPatient.php", {personID : currentID});

    // Change to edit view and update the state
    $('#profileView').fadeOut('fast');
    $('#editView').delay(500).fadeIn('fast');
    state = "edit";
  });

  // Sniffer for update doctor form submit
  $('#editView').on('submit', '#editDoctorForm', updateDoctor);

  // Sniffer for update patient form submit
  $('#editView').on('submit', '#editPatientForm', updatePatient);

  // Sniffer for fire doctor button click
  $('#editView').on('click', '#fireDoctor', function()
    {
      // Confirm action
      var check = confirm("Are you sure?");
      if (check)
      {
        $.post('php/removeDoctor.php', {personID : currentID},
          function(data)
          {
            if (data === "success")
            {
              // Reload if action taken
              window.location.reload();
            }
            else
            {
              alert('Something went wrong', 'warning');
            }
          }
        );
      }
    }
  );

  // Sniffer for dismiss patient button click
  $('#editView').on('click', '#dismissPatient', function()
    {
      // Confirm action
      var check = confirm("Are you sure?");
      if (check)
      {
        var date = prompt("Enter the dismissal date");
        if (date !== null && date !== "")
        {
          $.post('php/removePatient.php', {personID : currentID, dismiss : date},
            function(data)
            {
              if (data === "invalidDismiss")
              {
                alert("Invalid date", 'warning');
              }
              else if (data === "success")
              {
                // Reload if action taken successfully
                window.location.reload();
              }
              else
              {
                alert(data, 'error');
              }
            }
          );
        }
      }
    }
  );
});