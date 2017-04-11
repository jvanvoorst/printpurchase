// grab url parameters
var urlParams = urlObject({'url':window.location.href});
var isbn = urlParams.parameters.isbn;
var title = unescape(urlParams.parameters.title);
var author = unescape(urlParams.parameters.author);

$(function() {
    // initial hide submit button until delivery date is returned
    $('#submitBtn').hide();
    // retrieve book data from Coutts
    $.ajax({
        url: 'php/getbookinfo.php',
        type: 'GET',
        data: {'isbn' : urlParams.parameters.isbn},
        success: function(res, status) {
            var patronDate = adjustDate(Number(res));
            $('#deliveryTimeEst').html("<input class=\"form-control\" id=\"deliveryTimePatron\" type=\"text\" value=\"\" name=\"deliveryTimePatron\" readonly>");
            $('#deliveryTimePatron').val(patronDate);
            $('#deliveryTime').val(Number(res));
            $('#submitBtn').show();
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });

    // prefill book info
    $('#title').val(title);
    $('#author').val(author);
    $('#isbn').val(isbn);
    
    // Submit action
    $('form').submit( function(event) {        
        event.preventDefault();
        $('#submitBtn').fadeOut(300);
        $.ajax({
            url: 'php/submit.php',
            type: 'POST',
            data: $('form').serialize(),
            success: function(res, status) {
                console.log(res);
                window.location.replace("html/success.html");
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError: " + err);
            }
        });
    });
});

// adjust date returned from Coutts to be at least 5 days and add four otherwise
function adjustDate(date) {
    if (date <= 4) {
        return 18;
    } else {
        return date + 18;
    }
}

 // function to create object from url and it's parameters
function urlObject(options) {
    "use strict";
    /*global window, document*/

    var url_search_arr,
        option_key,
        i,
        urlObj,
        get_param,
        key,
        val,
        url_query,
        url_get_params = {},
        a = document.createElement('a'),
        default_options = {
            'url': window.location.href,
            'unescape': true,
            'convert_num': false
        };

    if (typeof options !== "object") {
        options = default_options;
    } else {
        for (option_key in default_options) {
            if (default_options.hasOwnProperty(option_key)) {
                if (options[option_key] === undefined) {
                    options[option_key] = default_options[option_key];
                }
            }
        }
    }

    a.href = options.url;
    url_query = a.search.substring(1);
    url_search_arr = url_query.split('&');

    if (url_search_arr[0].length > 1) {
        for (i = 0; i < url_search_arr.length; i += 1) {
            get_param = url_search_arr[i].split("=");

            if (options.unescape) {
                key = decodeURI(get_param[0]);
                val = decodeURI(get_param[1]);
            } else {
                key = get_param[0];
                val = get_param[1];
            }

            if (options.convert_num) {
                if (val.match(/^\d+$/)) {
                    val = parseInt(val, 10);
                } else if (val.match(/^\d+\.\d+$/)) {
                    val = parseFloat(val);
                }
            }

            if (url_get_params[key] === undefined) {
                url_get_params[key] = val;
            } else if (typeof url_get_params[key] === "string") {
                url_get_params[key] = [url_get_params[key], val];
            } else {
                url_get_params[key].push(val);
            }

            get_param = [];
        }
    }

    urlObj = {
        protocol: a.protocol,
        hostname: a.hostname,
        host: a.host,
        port: a.port,
        hash: a.hash.substr(1),
        pathname: a.pathname,
        search: a.search,
        parameters: url_get_params
    };

    return urlObj;
}


