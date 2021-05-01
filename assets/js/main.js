function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function get_time(stat){
  let today = new Date();
  let dd = String(today.getDate()).padStart(2, '0');
  let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  let yyyy = today.getFullYear();
  let h = addZero(today.getHours());
  let m = addZero(today.getMinutes());
  let s = addZero(today.getSeconds());

  if (stat == 'hari') {
    return yyyy+'-'+mm+'-'+dd;
  }else if(stat == 'all') {
    return yyyy+'-'+mm+'-'+dd+' '+h + ":" + m + ":" + s;
  }
}

function toastnya(mesej){
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  toastr.error("<center>"+mesej+"</center>");
}

function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57 ))
      return false;
  return true;
  // console.log(evt.key)
}

function comma_number(array){
  for (var i = 0; i < arrat.length; i++) {
    // console.log(arrat[i])
    const elem = document.getElementById(arrat[i]);

    elem.addEventListener("keydown",function(event){
        var key = event.which;
        if((key<48 || key>57) && key != 8) event.preventDefault();
    });

    elem.addEventListener("keyup",function(event){
        var value = this.value.replace(/,/g,"");
        this.dataset.currentValue=parseInt(value);
        var caret = value.length-1;
        while((caret-3)>-1)
        {
            caret -= 3;
            value = value.split('');
            value.splice(caret+1,0,",");
            value = value.join('');
        }
        this.value = value;
    });
  }
}

function block_ui(){
  $.blockUI({ 
    message: "Sedang Diproses", 
    css: { 
    border: 'none', 
    padding: '15px', 
    backgroundColor: '#000', 
    '-webkit-border-radius': '10px', 
    '-moz-border-radius': '10px', 
    opacity: .5, 
    color: '#fff' 
  } });
}

function bad_request(errorThrown,message,focus){
  switch (errorThrown) {
    case "Bad Request":
      toastnya(message)
      $("#".focus).focus();
      break;
    case "Unauthorized":
      toastnya(message)
      $("#".focus).focus();
      break;
    default:
      swal({
        text: "Koneksi Gagal, Sila Pastikan Perangkat Terhubung Jaringan Internet",
        icon: "warning",
        buttons: {
            cancel: false,
            confirm: true,
          },
        // dangerMode: true,
      })
      .then((hehe) =>{
        location.reload();
      });
      break;
  }
}

function getFormData(data){
  // var unindexed_array = $form.serializeArray();
  var indexed_array = {};

  $.map(data, function(n, i){
      indexed_array[n['name']] = n['value'];
  });

  return indexed_array;
}


function not_avaiable(){
  swal({
    title: "Belum Tersedia",
    text: "Maaf Fitur Belum Tersedia",
    icon: "warning",
    buttons: {
      cancel: false,
      confirm: true,
    },
    timer: 1500,
    // dangerMode: true,
  })
}

function logout(){
  swal({
    title: "Yakin ingin Logout?",
    text: "Anda akan keluar dari sistem",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((logout) => {
    if (logout) {
      // localStorage.removeItem("nik");
      // localStorage.removeItem("level");
      window.location.href = url+'home/logout';
    } else {
      swal("Terima kasih kerana masih di sistem");
    }
  });
}

function myFunction(a) {
  var x = $("#"+a);
  var xx = document.getElementById(a);

  
  if (xx.style.display === "none") {
    x.slideToggle();
  } else {
    x.slideToggle();
  }
}