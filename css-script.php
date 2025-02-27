<style type="text/css">
    .frm label {
        float: left;
        width: 150px;
    }

    .frm select {width: 140px;}

    .spacer-05 { clear: left; display: block; height: 5px; }
    .spacer-10 { clear: left; display: block; height: 10px; }

    .selpage{float: none !important; margin-left: 5px;}

    .logo { height: 40px; vertical-align: middle;}

    .help {cursor: help; position: relative; left: 3px;}

    .posts-container { max-height: 300px; overflow-x: hidden; overflow-y: auto; padding-left: 10px; width: 480px; border: 1px solid #aaa; }
    .nbutton {
        background-color: #39c54a;
        -webkit-border-radius: 2px;
        border: 1px solid #39c54a;
        color:#FFFFFF;
        cursor: pointer;
         -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.6);
        box-shadow: 0 1px 3px rgba(0,0,0,.6);
    }

    
    .nbutton:hover{
        background-color: #FFFFFF;
        color:#39c54a;
    }

    .nbutton-blue {
        background-color: #0093c7;
        -webkit-border-radius: 2px;
        border: 1px solid #0093c7;
        color:#FFFFFF;
        cursor: pointer;

    }
    .nbutton-blue:hover{
        background-color: #FFFFFF;
        color:#0093c7;
    }

    .big-blue-button {
        background-color: #0093c7;
        -webkit-border-radius: 2px;
        border: 1px solid #0093c7;
        color:#FFFFFF;
        cursor: pointer;
        font-size: 22px;
        padding-top:20px;
        padding-bottom:20px;
        padding-left:40px;
        padding-right:40px;
        box-shadow: 0 1px 3px rgba(0,0,0,.6);
    }
    .big-blue-button:hover {
        background-color: #FFFFFF;
        color:#0093c7;
    }

    .big-green-button {
        background-color: #39c54a;
        -webkit-border-radius: 2px;
        border: 1px solid #39c54a;
        color:#FFFFFF;
        cursor: pointer;
        font-size: 22px;
        padding-top:20px;
        padding-bottom:20px;
        padding-left:40px;
        padding-right:40px;
        box-shadow: 0 1px 3px rgba(0,0,0,.6);
    }
    .big-green-button:hover {
        background-color: #FFFFFF;
        color:#39c54a;
    }
    .pre-made-image{
        cursor: pointer;
    }
    .medium-green-button {
        background-color: #39c54a;
        -webkit-border-radius: 2px;
        border: 1px solid #39c54a;
        color:#FFFFFF;
        cursor: pointer;
        font-size: 18px;
        padding-top:3px;
        padding-bottom:3px;
        padding-left:15px;
        padding-right:15px;
        box-shadow: 0 1px 3px rgba(0,0,0,.6);
    }
    .medium-green-button:hover {
        background-color: #FFFFFF;
        color:#39c54a;
    }
</style>

<script type="text/javascript">

    function is_int(value) { 
        if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
            return true;
        } else { 
            return false;
        } 
    }
    
    function validate_range_number(value, min, max){
        if(is_int(value)){
            if((parseInt(value) >= parseInt(min)) && (parseInt(value) <= parseInt(max))){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function validateVideoStirEditForm()
    {
        var error = '', id, min, max, id_size;
        
        id = 'width', min = 50, max = 3000;
        if (!validate_range_number(document.getElementById(id).value, min, max)) {
            error += "- The " + id + " field must contain a \n number between " + min + " and " + max + ". \n";
        }
        
        id = 'height';
        if (!validate_range_number(document.getElementById(id).value, min, max)) {
            error += "- The " + id + " field must contain a \n number between " + min + " and " + max + ". \n";
        }
        
        id = 'val1', min = -3000, max = 3000;
        if (!validate_range_number(document.getElementById(id).value, min, max)) {
            error += "- The top or bottom field must contain a \n number between " + min + " and " + max + ". \n";
        }
        
        id = 'val2';
        if (!validate_range_number(document.getElementById(id).value, min, max)) {
            error += "- The left or right field must contain a \n number between " + min + " and " + max + ". \n";
        }
        
        id = 'url';
        if (parseInt(document.getElementById(id).value.length) != 32) {
            error += "- The Clip ID field must contain 32 characters. \nUse the clip ID that was created by the system.\nFor example: 75af040ae4daa2d4ff1fb353f9f1abcd";
        }
        
        id = 'rotation', min = 0, max = 360;
        if (document.getElementById(id).value != '') {
            if (!validate_range_number(document.getElementById(id).value, min, max)) {
                error += "- The rotation field must contain a \n number between " + min + " and " + max + ". \n";
            }
        }
        
        id = 'zoom', min = 0, max = 200;
        if (document.getElementById(id).value != '') {
            if (!validate_range_number(document.getElementById(id).value, min, max)) {
                error += "- The zoom field must contain a \n number between " + min + " and " + max + ". \n";
            }
        }
        
        id = 'playback-delay', min = 0, max = 200;
        if (document.getElementById(id).value != '') {
            if (!validate_range_number(document.getElementById(id).value, min, max)) {
                error += "- The delay field must contain a \n number between " + min + " and " + max + ". \n";
            }
        }
        
        id = 'auto-play-limit', min = 0, max = 10000;
        if (document.getElementById(id).value != '') {
            if (!validate_range_number(document.getElementById(id).value, min, max)) {
                error += "- The autoplay limit field must contain a \n number between " + min + " and " + max + ". \n";
            }
        }
        
        id = 'freeze', min = 1, max = 10000;
        if (document.getElementById(id).value != '') {
            if (!validate_range_number(document.getElementById(id).value, min, max)) {
                error += "- The freeze field must contain a \n number between " + min + " and " + max + ". \n";
            }
        }
        id = 'youtube', id_size = 0;
        id_size = parseInt(document.getElementById(id).value.length);
        if (id_size != 11 && id_size > 0 ) {
            error += "- A youtube clip id should have 11 characters in it. (for example : hzy6lmnAezk ). \nThis is an experimental optional feautre for showing one of your youtube clips instead of the floating clip\nin case user watched page from iphone/ipad.";
        }
        
        if (error != '') {
            alert(error);
            return false;
        } else {
            return true;
        }
    }
    
    function videostirValidateNewVideo()
    {
        var name = jQuery('#name').val()
        ,   code = jQuery('#embed').val();
        
        if (name.length < 1) {
            alert('Name is empty');
            return false;
        }
        
        if (code.length < 16 ) {
            alert(
                'Wait, you should first quickly prepare you VideoStir floating clip or select one from our clip market. '
                + '\n\nPaste the 1 line you got from videostir.com after transforming your video into a floating clip in the text box below.'
                + '\nClick "Next" to adjust the parameters that will appear and choose the pages/posts that will hold the clip from the list.'
            );
            return false;
        }
        if (code.indexOf('vsembed.js')!=-1 )
		{
//			alert('Please go back to your video page on VideoStir website and use the old embed code structure for your clip.\n'
//				+'Just click on the button saying "Old embed code" in the "Enjoy" step and copy the lines from there.'
//				+'\nWe will be happy to support you - just drop us a line to info@videostir.com');
			return true;
		}

        if (code.indexOf('videostir.start')!=-1 )
        {
//          alert('Please go back to your video page on VideoStir website and use the old embed code structure for your clip.\n'
//              +'Just click on the button saying "Old embed code" in the "Enjoy" step and copy the lines from there.'
//              +'\nWe will be happy to support you - just drop us a line to info@videostir.com');
            return true;
        }
		
		if (code.indexOf('VS.Player.show')===-1)
		{
			alert(
                'Wait, you should first quickly prepare you VideoStir floating clip or select one from our clip market. '
                + '\n\nPaste the 1 line you got from videostir.com after transforming your video into a floating clip in the text box below.'
                + '\nClick "Next" to adjust the parameters that will appear and choose the pages/posts that will hold the clip from the list.'
            );
            return false;
		}
        return true;
    }

</script>
