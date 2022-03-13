let getToast = (type, title, message) => {
    switch (type) {
        case "info":
            iziToast.info({
                title: title,
                message: message,
                position: "bottomRight",
                transitionIn: 'bounceInLeft',
                transitionOut: 'bounceOut',
                transitionInMobile: 'bounceInLeft',
                transitionOutMobile: 'bounceOutDown',
                messageSize: '15',
            });
            break;
        case "success":
            iziToast.success({
                title: title,
                message: message,
                position: "bottomRight",
                transitionIn: 'bounceInLeft',
                transitionOut: 'bounceOut',
                transitionInMobile: 'bounceInLeft',
                transitionOutMobile: 'bounceOutDown',
                messageSize: '15',
            });
            break;
        case "error":
            iziToast.error({
                title: title,
                message: message,
                position: "bottomRight",
                transitionIn: 'bounceInLeft',
                transitionOut: 'bounceOut',
                transitionInMobile: 'bounceInLeft',
                transitionOutMobile: 'bounceOutDown',
                messageSize: '15',
            });
            break;
        case "warning":
            iziToast.warning({
                title: title,
                message: message,
                position: "bottomRight",
                transitionIn: 'fadeInUp',
                transitionOut: 'fadeOut',
                transitionInMobile: 'fadeInUp',
                transitionOutMobile: 'fadeOutDown',
                messageSize: '15',
            });
            break;
        default:
            console.log("nothing");
            break;
    }
};


let numberOnly = (evt) => {
    var charCode = evt.which ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
};

let setPreload=(selector)=>{
    selector.html(` Saving <div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>`).attr("disabled", true);
}

let showMsg=(jqxHR)=>{
    $(".text-danger").text("")
    $.each(jqxHR.responseJSON.errors, function (prefix, val) {
        $(`.${prefix}`).text(val[0]);
    });
}

let isNull=(value)=>{
    return value!=null?value:'';
}
 
let isNullPrice=(value)=>{
    return value!=null?'₱ '+ value.toLocaleString() +'.00':'₱ 0.00';
 }

// $(".modalLogout").on('click',function(event){
//     $(".confirmModal").modal("show")
//     event.preventDefault();
//     document.getElementById('logout-form').submit();
//     window.location.reload()
// })

const popupCenter = ({ url, title, w, h }) => {
    const dualScreenLeft =
        window.screenLeft !== undefined ? window.screenLeft : window.screenX;
    const dualScreenTop =
        window.screenTop !== undefined ? window.screenTop : window.screenY;

    const width = window.innerWidth
        ? window.innerWidth
        : document.documentElement.clientWidth
        ? document.documentElement.clientWidth
        : screen.width;
    const height = window.innerHeight
        ? window.innerHeight
        : document.documentElement.clientHeight
        ? document.documentElement.clientHeight
        : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft;
    const top = (height - h) / 2 / systemZoom + dualScreenTop;
    const newWindow = window.open(
        url,
        title,
        `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      `
    );
    newWindow;
};

const month = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
];