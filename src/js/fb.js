window.fbAsyncInit = function() {
    FB.init({
        appId      : '468292440014166',
        xfbml      : true,
        version    : 'v2.3'
    });

	$(document).trigger('fbload');  //  <---- THIS RIGHT HERE TRIGGERS A CUSTOM EVENT CALLED 'fbload'
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        getInfo();
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
}
function getInfo() {
    FB.api('/me', function(response) {

        $.ajax
        ({
            url: '?page=homepage&social=fb&email=' + response.email + '&uid=' + response.id,

            type: 'GET',

            success: function ()
            {
                console.log('success login!');
                rude.url.redirect('?page=homepage');
            }
        });
    });
}

function fb_login() {
	FB.login( function() {}, { scope: 'email,public_profile' } );
}
