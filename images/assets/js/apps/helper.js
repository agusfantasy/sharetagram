function timeVal() {
    //  discuss at: http://phpjs.org/functions/time/
    // original by: GeekFG (http://geekfg.blogspot.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: metjay
    // improved by: HKM
    //   example 1: timeStamp = time();
    //   example 1: timeStamp > 1000000000 && timeStamp < 2000000000
    //   returns 1: true

    return Math.floor(new Date()
        .getTime() / 1000);
}

function humanTiming(time)
{
    //$time = strtotime('2010-04-28 17:25:43');
    time = timeVal() - time;
    var tokens = [{
        'y' : 31536000,
        'm' : 2592000,
        'w' : 604800,
        'd' : 86400,
        'h' : 3600,
        'min': 60,
        's' : 1
    }];

    return tokens;
    for (var i = 0, i < tokens.length $unit => $text) {
        if ($time < $unit) continue;
    $numberOfUnits = floor($time / $unit);
    //return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    return $numberOfUnits.$text;*/
}

