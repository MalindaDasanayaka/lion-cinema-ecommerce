function changeView() {
    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");
  
    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");
}

function showPassword() {
    var textfield = document.getElementById("password");
    var button = document.getElementById("psb");
  
    if (textfield.type == "password") {
      textfield.type = "text";
      button.className = "bi bi-eye-fill text-white";
    } else {
      textfield.type = "password";
      button.className = "bi bi-eye-slash-fill text-white";
    }
}

function signin() {
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var rememberme = document.getElementById("rememberme");

  var form = new FormData();
  form.append("e", email.value);
  form.append("p", password.value);
  form.append("r", rememberme.checked);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        window.location = "index.php";
      } else {
        document.getElementById("msg").innerHTML = response;
        document.getElementById("msgdiv").className = "d-block";
      }
    }
  }

  request.open("POST", "signInProcess.php", true);
  request.send(form);
}

function showPassword1() {
  var textfield = document.getElementById("password1");
  var button = document.getElementById("psb1");

  if (textfield.type == "password") {
    textfield.type = "text";
    button.className = "bi bi-eye-fill text-white";
  } else {
    textfield.type = "password";
    button.className = "bi bi-eye-slash-fill text-white";
  }
}

function signup() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email1");
    var password = document.getElementById("password1");
    var mobile = document.getElementById("mobile");
    var gender = document.getElementById("gender");
  
    var form = new FormData();
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("m", mobile.value);
    form.append("g", gender.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
  
        if (response == "success") {
          document.getElementById("msg1").innerHTML = "Registration Successfull";
          document.getElementById("msg1").className = "alert alert-success";
          document.getElementById("msgdiv1").className = "d-block";
        } else {
          document.getElementById("msg1").innerHTML = response;
          document.getElementById("msgdiv1").className = "d-block";
        }
      }
    }
  
    request.open("POST", "signupProcess.php", true);
    request.send(form);
}

var forgotPasswordModal;

function forgotPassword() {
  var email = document.getElementById("email");

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var text = request.responseText;

      if (text == "Success") {
        Swal.fire(
          'Success!',
          'Verification code has been sent successfully. Please check your email.',
          'success'
        );
        var modal = document.getElementById("fpmodal");
        forgotPasswordModal = new bootstrap.Modal(modal);
        forgotPasswordModal.show();
      } else {
        document.getElementById("msg1").innerHTML = text;
        document.getElementById("msgdiv1").className = "d-block";
      }
    }
  }

  request.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
  request.send();
}

function showPassword2() {
    var textfield = document.getElementById("np");
    var button = document.getElementById("npb");
  
    if (textfield.type == "password") {
      textfield.type = "text";
      button.className = "bi bi-eye-fill text-white";
    } else {
      textfield.type = "password";
      button.className = "bi bi-eye-slash-fill text-white";
    }
}

function showPassword3() {
    var textfield = document.getElementById("rnp");
    var button = document.getElementById("rnpb");
  
    if (textfield.type == "password") {
      textfield.type = "text";
      button.className = "bi bi-eye-fill text-white";
    } else {
      textfield.type = "password";
      button.className = "bi bi-eye-slash-fill text-white";
    }
}

function resetPassword() {
    var email = document.getElementById("email");
    var newPassword = document.getElementById("np");
    var retypePassword = document.getElementById("rnp");
    var verification = document.getElementById("vcode");
  
    var form = new FormData();
    form.append("e", email.value);
    form.append("n", newPassword.value);
    form.append("r", retypePassword.value);
    form.append("v", verification.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if (response == "success") {
          Swal.fire(
            'Success!',
            'Password updated successfully.',
            'success'
          );
          forgotPasswordModal.hide();
        } else {
          Swal.fire(
            'Error!',
            response,
            'error'
          );
        }
      }
    }
  
    request.open("POST", "resetPasswordProcess.php", true);
    request.send(form);
}

function signout() {
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if (response == "success") {
          window.location.reload();
        }
      }
    }
  
    request.open("GET", "signOutProcess.php", true);
    request.send();
}

var av;
function adminVerification(){
  
  var email = document.getElementById("email");
  var password = document.getElementById("password");

  var form = new FormData();
  form.append("e",email.value);
  form.append("p",password.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if(response == "Success"){
        Swal.fire(
          'Success!',
          'Please take a look at your email to find the VERIFICATION CODE.',
          'success'
        );
        var adminVerificationModal = document.getElementById("verificationModal");
        av = new bootstrap.Modal(adminVerificationModal);
        av.show();
      } else {
        document.getElementById("msg").innerHTML = response;
        document.getElementById("msgdiv").className = "d-block";
      }
    }
  }

  request.open("POST", "adminVerificationProcess.php", true);
  request.send(form);

}

function verify(){

    var code = document.getElementById("vcode");
  
    var form = new FormData();
    form.append("c",code.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if(response == "success"){
          av.hide();
          window.location = "adminPanel.php";
        } else {
          Swal.fire(
            'Error!',
            response,
            'error'
          );
        }
      }
    }
    
    request.open("POST", "verificationProcess.php", true);
    request.send(form);
  
}

function adminSignout() {
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if (response == "success") {
          window.location = "adminSignin.php";
        }
      }
    }
  
    request.open("GET", "adminSignoutProcess.php", true);
    request.send();
}

function adminRegister() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var mobile = document.getElementById("mobile");
  
    var form = new FormData();
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("m", mobile.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
  
        if (response == "success") {
          document.getElementById("msg").innerHTML = "Registration Successfull";
          document.getElementById("msg").className = "alert alert-success";
          document.getElementById("msgdiv").className = "d-block";
        } else {
          document.getElementById("msg").innerHTML = response;
          document.getElementById("msgdiv").className = "d-block";
        }
      }
    }
  
    request.open("POST", "adminRegistrationProcess.php", true);
    request.send(form);
}

function changeProfileImg() {
  var img = document.getElementById("profileimage");
  var f = new FormData();

  f.append("i", img.files[0]);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        var response = request.responseText;
        if (response == "empty") {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select your profile image.',
          });
        } else {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Profile Image Updated.',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload();
            document.getElementById("i").src = response;
          });
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to upload profile image. Please try again later.',
        });
      }
    }
  };

  request.open("POST", "profileImgUpload.php", true);
  request.send(f);
}

function updateProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var pcode = document.getElementById("pcode");
  
    var form = new FormData();

    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("m", mobile.value);
    form.append("l1", line1.value);
    form.append("l2", line2.value);
    form.append("p", province.value);
    form.append("d", district.value);
    form.append("c", city.value);
    form.append("pc", pcode.value);
  
    var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        var response = request.responseText;
        if (response == "Updated") {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Profile Successfully Updated.',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response,
          });
        }
      }
    }
};

request.open("POST", "updateProfileProcess.php", true);
request.send(form);
}

function changeAdminProfileImg() {
  var img = document.getElementById("adprofileimage");

  var f = new FormData();
  f.append("i", img.files[0]);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var response = request.responseText;
      if (response == "empty") {
        Swal.fire(
          'Error!',
          'Please select your profile image.',
          'error'
        );
      } else {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Profile Image Updated.',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.reload();
          document.getElementById("i").src = response;
        });
      }
    }
  };

  request.open("POST", "adminProfileImgUpload.php", true);
  request.send(f);
}

function updateAdminProfile() {
    var fname = document.getElementById("adfname");
    var lname = document.getElementById("adlname");
    var mobile = document.getElementById("admobile");
    var password = document.getElementById("password");
  
    var form = new FormData();
  
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("m", mobile.value);
    form.append("p", password.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
  
        if (response == "Updated") {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Profile Successfully Updated.',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response,
          });
        }
      }
    }
  
    request.open("POST", "updateAdminProfileProcess.php", true);
    request.send(form);
}

function loadMainImg(id) {
    var sample_img = document.getElementById(id).src;
    var main_img = document.getElementById("mainImg");
  
    main_img.style.backgroundImage = "url(" + sample_img + ")";
}

var av;
function superAdminVerification(){
  
  var email = document.getElementById("suemail");

  var form = new FormData();
  form.append("e",email.value);
  
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if(response == "Success"){
        Swal.fire(
          'Success!',
          'Please take a look at your email to find the VERIFICATION CODE.',
          'success'
        );
        var adminVerificationModal = document.getElementById("verificationModal1");
        av = new bootstrap.Modal(adminVerificationModal);
        av.show();
      } else {
        Swal.fire(
          'Error!',
          response,
          'error'
        );
      }
    }
  }

  request.open("POST", "superAdminVerificationProcess.php", true);
  request.send(form);

}

function verify1(){

    var code = document.getElementById("vcode1");
  
    var form = new FormData();
    form.append("c",code.value);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if(response == "success"){
          av.hide();
          window.location = "manageAdmins.php";
        } else {
          Swal.fire(
            'Error!',
            response,
            'error'
          );
        }
      }
    }
    
    request.open("POST", "sAdminVerificationProcess.php", true);
    request.send(form);
  
}

function superAdminSignout() {
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        if (response == "success") {
          window.location = "adminSignin.php";
        }
      }
    }
  
    request.open("GET", "SuperAdminSignoutProcess.php", true);
    request.send();
}

function searchUser(x) {

    var txt = document.getElementById("user_search");
    
    var form = new FormData();
    form.append("t", txt.value);
    form.append("page", x);
  
    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("userSearchResult").innerHTML = response;
        }
    }
  
    request.open("POST", "userSearchProcess.php", true);
    request.send(form);
  
}

var um;

function viewUserModal(id){
  var m = document.getElementById("viewUserModal"+id);
  um = new bootstrap.Modal(m);
  um.show();
}

function blockUser(email){

    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        Swal.fire(
          'Status Changed!',
          response,
          'success'
        ).then(() => {
          window.location.reload();
        });
      }
    }
    
    request.open("GET", "userBlockProcess.php?email=" + email, true);
    request.send();
  
}

function blockAdmin(email){

    var request = new XMLHttpRequest();
  
    request.onreadystatechange = function () {
      if (request.status == 200 && request.readyState == 4) {
        var response = request.responseText;
        Swal.fire(
          'Status Changed!',
          response,
          'success'
        ).then(() => {
          window.location.reload();
        });
      }
    }
    
    request.open("GET", "adminBlockProcess.php?email=" + email, true);
    request.send();
  
}

function addProduct() {
  var type = document.getElementById("type");
  var category = document.getElementById("category");
  var language = document.getElementById("language");
  var title = document.getElementById("title");
  var availability = 0;

  if (document.getElementById("re").checked) {
    availability = 1;
  } else if (document.getElementById("cs").checked) {
    availability = 2;
  }
  var ratings = document.getElementById("ratings");
  var qty = document.getElementById("qty");
  var cost = document.getElementById("cost");
  var discount = document.getElementById("discount");
  var redate = document.getElementById("redate");
  var runtime = document.getElementById("runtime");
  var trailer = document.getElementById("trailer");
  var desc = document.getElementById("desc");
  var image = document.getElementById("imageuploader");

  var form = new FormData();
  form.append("ty", type.value);
  form.append("ca", category.value);
  form.append("l", language.value);
  form.append("ti", title.value);
  form.append("av", availability);
  form.append("ra", ratings.value);
  form.append("q", qty.value);
  form.append("co", cost.value);
  form.append("di", discount.value);
  form.append("rd", redate.value);
  form.append("rt", runtime.value);
  form.append("tr", trailer.value);
  form.append("de", desc.value);

  var file_count = image.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("image" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "Product Successfully Added.") {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response,
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.reload();
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response,
          confirmButtonText: 'OK'
        });
      }
    }
  }
  request.open("POST", "addProductProcess.php", true);
  request.send(form);
}

function changeProductImage() {
  var image = document.getElementById("imageuploader");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count <= 3) {
      for (var x = 0; x < file_count; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);

        document.getElementById("i" + x).src = url;
      }
    } else {
      alert(
        file_count +
          " files. You are proceed to upload only 3 or less than 3 files."
      )
    }
  }
}

function searchProduct(x) {

  var txt = document.getElementById("product_search");
  
  var form = new FormData();
  form.append("t", txt.value);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
      if (request.status == 200 & request.readyState == 4) {
          var response = request.responseText;
          document.getElementById("productSearchResult").innerHTML = response;
      }
  }

  request.open("POST", "productSearchProcess.php", true);
  request.send(form);

}

function changeAvailability(id){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response = "success"){
        Swal.fire({
          icon: 'success',
          title: 'Availability Changed!',
        }).then(() => {
          window.location.reload();
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response,
        });
      }
    }
  }
  
  request.open("GET", "changeAvailabilityProcess.php?id=" + id, true);
  request.send();

}

var pm;

function viewProductModal(id){
  var m = document.getElementById("viewProductModal"+id);
  pm = new bootstrap.Modal(m);
  pm.show();
}

function blockProduct(id){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      Swal.fire(
        'Status Changed!',
        response,
        'success'
      ).then(() => {
        window.location.reload();
      });
    }
  }
  
  request.open("GET", "productBlockProcess.php?id=" + id, true);
  request.send();

}

function typeReg(){
  var type = document.getElementById("ty");

  var form = new FormData();
  form.append("t", type.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg1").innerHTML = "Type Successfully Registered";
        document.getElementById("msg1").className = "alert alert-success";
        document.getElementById("msgDiv1").className = "d-block";
        type.value = "";
        
      } else {
        document.getElementById("msg1").innerHTML = response;
        document.getElementById("msgDiv1").className = "d-block";
      }
    }
  }

  request.open("POST", "typeRegisterProcess.php", true);
  request.send(form);

}

function categoryReg(){
  var category = document.getElementById("cat");

  var form = new FormData();
  form.append("c", category.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg2").innerHTML = "Category Successfully Registered";
        document.getElementById("msg2").className = "alert alert-success";
        document.getElementById("msgDiv2").className = "d-block";
        category.value = "";
        
      } else {
        document.getElementById("msg2").innerHTML = response;
        document.getElementById("msgDiv2").className = "d-block";
      }
    }
  }

  request.open("POST", "categoryRegisterProcess.php", true);
  request.send(form);
  
}

function languageReg(){
  var language = document.getElementById("lan");

  var form = new FormData();
  form.append("l", language.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg3").innerHTML = "Language Successfully Registered";
        document.getElementById("msg3").className = "alert alert-success";
        document.getElementById("msgDiv3").className = "d-block";
        language.value = "";
        
      } else {
        document.getElementById("msg3").innerHTML = response;
        document.getElementById("msgDiv3").className = "d-block";
      }
    }
  }

  request.open("POST", "languageRegisterProcess.php", true);
  request.send(form);
  
}

function setDiscount(){
  var discount = document.getElementById("dis");

  var form = new FormData();
  form.append("di", discount.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg4").innerHTML = "Discount Updated Successfully";
        document.getElementById("msg4").className = "alert alert-success";
        document.getElementById("msgDiv4").className = "d-block";
        language.value = "";
        
      } else {
        document.getElementById("msg4").innerHTML = response;
        document.getElementById("msgDiv4").className = "d-block";
      }
    }
  }

  request.open("POST", "setDiscountProcess.php", true);
  request.send(form);
  
}

function deliveryUpdate(id){
  var cost = document.getElementById("delivery"+id).value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        document.getElementById("msg5").innerHTML = "Delivery Cost Successfully Updated";
        document.getElementById("msg5").className = "alert alert-success";
        document.getElementById("msgDiv5").className = "d-block";
        
      } else {
        document.getElementById("msg5").innerHTML = response;
        document.getElementById("msgDiv5").className = "d-block";
      }
    }
  }

  request.open("GET", "deliveryUpdateProcess.php?id="+ id + "&cost=" + cost, true);
  request.send();
  
}

function sendid(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "success") {
        window.location = "updateProduct.php";
      } else {
        alert(response);
      }
    }
  }

  request.open("GET", "sendIdProcess.php?id=" + id, true);
  request.send();
}

function updateProduct() {
  var title = document.getElementById("ti");
  var ratings = document.getElementById("ra");
  var qty = document.getElementById("q");
  var cost = document.getElementById("co");
  var discount = document.getElementById("dis");
  var redate = document.getElementById("rd");
  var runtime = document.getElementById("rt");
  var trailer = document.getElementById("tra");
  var description = document.getElementById("d");
  var images = document.getElementById("imageuploader");

  var form = new FormData();

  form.append("ti", title.value);
  form.append("ra", ratings.value);
  form.append("q", qty.value);
  form.append("co", cost.value);
  form.append("di", discount.value);
  form.append("rd", redate.value);
  form.append("rt", runtime.value);
  form.append("tr", trailer.value);
  form.append("d", description.value);

  var file_count = images.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("i" + x, images.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response == "Product has been Updated.") {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response,
        }).then(() => {
          window.location = "manageProducts.php";
        });
      } else if (response.includes("Product has been Updated.") && !response.includes("Error")) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Product has been Updated.',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location = "manageProducts.php";
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response,
          confirmButtonText: 'OK'
        });
      }
    }
  }

  request.open("POST", "updateProductProcess.php", true);
  request.send(form);

}

function basicSearch(x) {
  var txt = document.getElementById("basic_search_txt");
  var select = document.getElementById("basic_search_select");

  var form = new FormData();
  form.append("t", txt.value);
  form.append("s", select.value);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("POST", "basicSearchProcess.php", true);
  request.send(form);
}

function preOrder(x) {

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("GET", "preOrderSAProcess.php?page="+x, true);
  request.send();
}

function newRelease(x) {

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("GET", "newReleaseSAProcess.php?page="+x, true);
  request.send();
}

function topSelling(x) {

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("GET", "topSellingSAProcess.php?page="+x, true);
  request.send();
}

function topRated(x) {

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("GET", "topRatedSAProcess.php?page="+x, true);
  request.send();
}

function categoryWise(id,x) {

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("basicSearchResult").innerHTML = response;
    }
  }

  request.open("GET", "categoryWiseSAProcess.php?id=" + id + "&page=" + x, true);
  request.send();
}

function advancedSearch(x) {
  var txt = document.getElementById("ad_text");
  var type = document.getElementById("ty");
  var category = document.getElementById("cat");
  var language = document.getElementById("lan");
  var availability = document.getElementById("av");
  var ryear = document.getElementById("ry");
  var from = document.getElementById("pf");
  var to = document.getElementById("pt");

  var rat;

  if(document.getElementById("10").checked){
    rat = 10;
  }else if(document.getElementById("9").checked){
    rat = 9;
  }else if(document.getElementById("8").checked){
    rat = 8;
  }else if(document.getElementById("7").checked){
    rat = 7;
  }else if(document.getElementById("6").checked){
    rat = 6;
  }else if(document.getElementById("5").checked){
    rat = 5;
  }else if(document.getElementById("l4").checked){
    rat = 4;
  }

  var sort = document.getElementById("s");

  var form = new FormData();
  form.append("txt", txt.value);
  form.append("t", type.value);
  form.append("c", category.value);
  form.append("l", language.value);
  form.append("a", availability.value);
  form.append("y", ryear.value);
  form.append("pf", from.value);
  form.append("pt", to.value);
  form.append("r", rat);
  form.append("s", sort.value);
  form.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("view_area").innerHTML = response;
    }
  }

  request.open("POST", "advancedSearchProcess.php", true);
  request.send(form);
}

function singleProductViewHome(id) {
  window.location = "singleProductView.php?id=" + id;
}

function loadMainImg(id) {
  var sample_img = document.getElementById("productImg" + id);
  var main_img = document.getElementById("mainImg");

  main_img.src = sample_img.src;
}

function check_value(qty) {
  var input = document.getElementById("qty_input");

  if (input.value <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Quantity must be 1 or more.',
    });
    input.value = 1;
  } else if (input.value > qty) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Insufficient Quantity.',
    });
    input.value = qty;
  }
}

function qty_inc(qty) {
  var input = document.getElementById("qty_input");

  if (input.value < qty) {
    var newValue = parseInt(input.value) + 1;
    input.value = newValue;
  } else {
    Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Maximum quantity has been reached.',
    });
    input.value = qty;
  }
}

function qty_dec() {
  var input = document.getElementById("qty_input");

  if (input.value > 1) {
    var newValue = parseInt(input.value) - 1;
    input.value = newValue;
  } else {
    Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Minimum quantity has been reached.',
    });
    input.value = 1;
  }
}

function check_value_cs() {
  var input = document.getElementById("qty_input");

  if (input.value <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Quantity must be 1 or more.',
    });
    input.value = 1;
  }
}

function qty_inc_cs() {
  var input = document.getElementById("qty_input");

  var newValue = parseInt(input.value) + 1;
  input.value = newValue;
  
}

function addToCartFromSPV(id) {
  var q = document.getElementById("qty_input").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response === "New product added to the cart.") {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: response,
          showConfirmButton: false,
          timer: 1500
        });
      } else if (response === "Cart Updated") {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: response,
          showConfirmButton: false,
          timer: 1500
        });
      } else if (response === "Please Login or Signup first.") {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: response,
        }).then(() => {
          window.location = "signin.php";
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: response,
        });
      }
    }
  }

  request.open("GET", "addToCartFromSPVProcess.php?id=" + id + "&q=" + q, true);
  request.send();
}

function addToWatchlist(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;

      if (response == "added") {
        document.getElementById("heart" + id).style.className = "text-danger";
        window.location.reload();
      } else if (response == "removed") {
        document.getElementById("heart" + id).style.className = "text-dark";
        window.location.reload();
      } else {
        alert(response);
      }
    }
  }

  request.open("GET", "addToWatchlistProcess.php?id=" + id, true);
  request.send();
}

function printInvoice(){
  var restorePage = document.body.innerHTML;
  var page = document.getElementById("page").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = restorePage;
}

function watchlistSearch() {

  var txt = document.getElementById("watchlist_search");
  
  var form = new FormData();
  form.append("t", txt.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
      if (request.status == 200 & request.readyState == 4) {
          var response = request.responseText;
          document.getElementById("watchlistSearchResults").innerHTML = response;
      }
  }

  request.open("POST", "watchlistSearchProcess.php", true);
  request.send(form);

}

function removeFromWatchlist(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'Do you want to remove this item from the Watchlist?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, remove it!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
      var request = new XMLHttpRequest();
      request.onreadystatechange = function () {
        if (request.readyState == 4) {
          if (request.status == 200) {
            var response = request.responseText;
            if (response == 'success') {
              Swal.fire({
                title: 'Removed!',
                text: 'Item removed from Watchlist.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire(
                'Error!',
                response,
                'error'
              );
            }
          } else {
            Swal.fire(
              'Error!',
              'Failed to remove product from Watchlist.',
              'error'
            );
          }
        }
      }

      request.open("GET", "removeFromWatchlistProcess.php?id=" + id, true);
      request.send();
    }
  });
}

function addToCart(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        var response = request.responseText;
        if (response === "New product added to the cart.") {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response,
            showConfirmButton: false,
            timer: 1500
          });
        } else if (response === "Cart Updated") {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response,
            showConfirmButton: false,
            timer: 1500
          });
        } else if (response === "Please Login or Signup first.") {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response,
          }).then(() => {
            window.location = "signin.php";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response,
          });
        }
      }
    }
  }

  request.open("GET", "addToCartProcess.php?id=" + id, true);
  request.send();
}

function cartSearch() {

  var txt = document.getElementById("cart_search");
  
  var form = new FormData();
  form.append("t", txt.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 & request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("cartSearchResults").innerHTML = response;
    }
  }

  request.open("POST", "cartSearchProcess.php", true);
  request.send(form);

}

function check_value_cart(id, qty) {
  var input = document.getElementById("qty_input_" + id);

  if (input.value <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Quantity must be 1 or more.',
    });
    input.value = 1;
  } else if (input.value > qty) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Insufficient Quantity.',
    });
    input.value = qty;
  }
}

function cart_qty_inc(id, qty) {
  var input = document.getElementById("qty_input_" + id);

  if (input.value < qty) {
    var newValue = parseInt(input.value) + 1;
    input.value = newValue;
  } else {
    Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Maximum quantity has been reached.',
    });
    input.value = qty;
  }
}

function cart_qty_dec(id) {
  var input = document.getElementById("qty_input_" + id);

  if (input.value > 1) {
    var newValue = parseInt(input.value) - 1;
    input.value = newValue;
  } else {
    Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Minimum quantity has been reached.',
    });
    input.value = 1;
  }
}

function check_value_cart_cs(id) {
  var input = document.getElementById("qty_input_" + id);

  if (input.value <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Quantity must be 1 or more.',
    });
    input.value = 1;
  }
}

function cart_qty_inc_cs(id) {
  var input = document.getElementById("qty_input_"+id);

  var newValue = parseInt(input.value) + 1;
  input.value = newValue;
  
}

function changeQTY(id) {
  var qty = document.getElementById("qty_input_"+id).value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if (response == "Updated") {
        window.location.reload();
      } else {
        alert(response);
      }
    }
  }

  request.open("GET","cartQtyUpdateProcess.php?id=" + id + "&qty=" + qty,true);
  request.send();
}

function checkOut() {
    var f = new FormData();
    f.append("cart", "true");

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                try {
                    var response = request.responseText;
                    var payment = JSON.parse(response);
                    if (payment.status === "success") {
                        doCheckout(payment, "checkoutProcess.php");
                    } else {
                        alert("An error occurred: " + payment.message);
                    }
                } catch (e) {
                    console.error("JSON parsing error:", e);
                    console.log("Raw response:", response);
                    alert("An error occurred while retrieving payment data. Please try again.");
                }
            } else {
                alert("A server error occurred. Please check and try again.");
            }
        }
    };

    request.open("POST", "paymentProcess.php", true);
    request.send(f);
}

function doCheckout(payment, path) {
    
  // Payment completed. It can be a successful failure.
  payhere.onCompleted = function onCompleted(orderId) {
      console.log("Payment completed. OrderID:" + orderId);
      // Note: validate the payment and show success or failure page to the customer

      var f = new FormData();
      f.append("payment", JSON.stringify(payment));

      var request = new XMLHttpRequest();
      request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
              var response = request.responseText;
              if (response == "Success") {
                  window.location = "invoice.php?id=" + orderId;
              } else {
                  alert(response);
              }
          }
      }

      request.open("POST", path, true);
      request.send(f);
  };

  // Payment window closed
  payhere.onDismissed = function onDismissed() {
      // Note: Prompt user to pay again or show an error page
      console.log("Payment dismissed");
  };

  // Error occurred
  payhere.onError = function onError(error) {
      // Note: show an error page
      console.log("Error:"  + error);
  };

  // Show the payhere.js popup, when "PayHere Pay" is clicked
  // document.getElementById('payhere-payment').onclick = function (e) {
      payhere.startPayment(payment);
  // };
}

function buyNow(id) {
  var qty = document.getElementById("qty_input");

  if (qty.value > 0) {
    var f = new FormData();
    f.append("cart", false);
    f.append("id", id);
    f.append("qty", qty.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var response = request.responseText;

        try {
          var payment = JSON.parse(response);

          if (payment.status === "error") {
            alert(payment.message); 
          } else {
            payment.product_id = id;
            payment.qty = qty.value;
            doCheckout(payment, "buynowProcess.php");
          }
        } catch (e) {
          console.error("JSON parsing error:", response);
          alert("An unexpected error occurred.");
        }
      }
    };

    request.open("POST", "paymentProcess.php", true);
    request.send(f);
  } else {
    alert("Please enter a valid amount.");
  }
}


function deleteFromCart(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you really want to remove this item from the cart?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, remove it!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
      var request = new XMLHttpRequest();

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var response = request.responseText;
          if (response == "Removed") {
            Swal.fire({
              title: 'Removed!',
              text: 'Product removed from Cart.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire(
              'Error!',
              response,
              'error'
            );
          }
        }
      }

      request.open("GET", "deleteFromCartProcess.php?id=" + id, true);
      request.send();
    }
  });
}

function cancelOrder(id, q) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you really want to cancel this order?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, cancel order!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
      var request = new XMLHttpRequest();

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var response = request.responseText;
          if (response == "success") {
            Swal.fire({
              title: 'Cancelled!',
              text: 'Your order has been cancelled.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire(
              'Error!',
              response,
              'error'
            );
          }
        }
      }

      request.open("GET", "cancelOrderProcess.php?id=" + id + "&qty=" + q, true);
      request.send();
    }
  });
}

var fm;
function addFeedback(id){
  var m = document.getElementById("feedbackmodal"+id);
  fm = new bootstrap.Modal(m);
  fm.show();
}

function saveFeedback(id) {
  var type;

  if (document.getElementById("type1_" + id).checked) {
    type = 1;
  } else if (document.getElementById("type2_" + id).checked) {
    type = 2;
  } else if (document.getElementById("type3_" + id).checked) {
    type = 3;
  }

  var feedback = document.getElementById("feed_" + id);

  if (!type) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Please select a feedback type!'
    });
    return;
  }

  if (!feedback.value.trim()) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Please provide your feedback!'
    });
    return;
  }

  Swal.fire({
    title: 'Are you sure?',
    text: 'Do you want to save this feedback?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, save it!',
    cancelButtonText: 'No, leave it'
  }).then((result) => {
    if (result.isConfirmed) {
      var form = new FormData();
      form.append("pid", id);
      form.append("t", type);
      form.append("f", feedback.value);

      var request = new XMLHttpRequest();

      request.onreadystatechange = function () {
        if (request.readyState == 4) {
          if (request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
              Swal.fire({
                title: 'Saved!',
                text: 'Feedback has been saved.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                fm.hide();
              });
            } else {
              Swal.fire(
                'Error!',
                response,
                'error'
              );
            }
          } else {
            Swal.fire(
              'Error!',
              'Failed to save feedback.',
              'error'
            );
          }
        }
      }

      request.open("POST", "saveFeedbackProcess.php", true);
      request.send(form);
    }
  });
}

function invoiceView(id) {
  window.location = "invoice.php?id=" + id;
}

function deleteFromHistory(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you really want to remove this item from your history?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
      var request = new XMLHttpRequest();

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var response = request.responseText;
          if (response == "success") {
            Swal.fire({
              title: 'Deleted!',
              text: 'Item successfully removed from history.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire(
              'Error!',
              response,
              'error'
            );
          }
        }
      }

      request.open("GET", "deleteFromHistoryProcess.php?id=" + id, true);
      request.send();
    }
  });
}

function deleteAll() {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you really want to remove all items from your history?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete them!',
    cancelButtonText: 'No, keep them'
  }).then((result) => {
    if (result.isConfirmed) {
      var request = new XMLHttpRequest();

      request.onreadystatechange = function () {
        if (request.readyState == 4) {
          if (request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
              Swal.fire({
                title: 'Deleted!',
                text: 'All items successfully removed from history.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire(
                'Error!',
                response,
                'error'
              );
            }
          } else {
            Swal.fire(
              'Error!',
              'Failed to delete items.',
              'error'
            );
          }
        }
      }

      request.open("GET", "deleteAllProcess.php", true);
      request.send();
    }
  });
}

function viewOrderModal(id) {

  var table = document.getElementById("orderModel");

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      table.innerHTML = response;
      $('#orderModal').modal('show');
    }
  }

  request.open("GET", "orderDetails.php?id=" + id, true);
  request.send();
}

function searchInvoice(){
  var txt = document.getElementById("searchtxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
        document.getElementById("viewArea").innerHTML = response;
    }
  }
  
  request.open("GET", "searchInvoiceProcess.php?order_id=" + txt, true);
  request.send();
}

function findSellings(){

  var from = document.getElementById("from").value;
  var to = document.getElementById("to").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      document.getElementById("viewArea").innerHTML = response;
    }
  }
  
  request.open("GET", "findSellingsProcess.php?f=" + from + "&t=" + to, true);
  request.send();

}

function changeInvoiceStatus(id){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if(response == "success"){
        window.location.reload();
      }else{
        alert(response);
      }
    }
  }
  
  request.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
  request.send();

}

function denyOrder(id,q){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if(response == "success"){
        window.location.reload();
      }else{
        alert(response);
      }
    }
  }
  
  request.open("GET", "denyOrderProcess.php?id=" + id + "&qty=" + q, true);
  request.send();

}

function undoDenyOrder(id,q){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      if(response == "success"){
        window.location.reload();
      }else{
        alert(response);
      }
    }
  }
  
  request.open("GET", "undoDenyOrderProcess.php?id=" + id + "&qty=" + q, true);
  request.send();

}

function back(){
  window.location = "adminReports.php";
}

function printReport(){
  var originalContent = document.body.innerHTML;
  var printArea = document.getElementById("printArea").innerHTML;

  document.body.innerHTML = printArea;
  window.print();
  document.body.innerHTML = originalContent;

}

function loadChart(){
  var ctx = document.getElementById("soldChart");
  var cix = document.getElementById("incomeChart");

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.status == 200 && request.readyState == 4) {
      var response = request.responseText;
      var data = JSON.parse(response);

      // Most sold products chart
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: data.soldChart.labels,
          datasets: [{
            label: 'Most Sold Products',
            data: data.soldChart.data,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Daily income chart
      new Chart(cix, {
        type: 'line',
        data: {
          labels: data.incomeChart.labels,
          datasets: [{
            label: 'Net Income',
            data: data.incomeChart.data,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  }
  
  request.open("POST", "loadChartProcess.php", true);
  request.send();
}