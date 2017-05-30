document.getElementById('ctl00_ContentPlaceHolder1_tsearch').value = 'ранок';
document.getElementById('ctl00_ContentPlaceHolder1_search').click();
document.getElementById('article_full').innerHTML;

// --

var newWord = null;
var htmlText = null;

var xhrIn = new XMLHttpRequest();
var xhrOut = new XMLHttpRequest();

var NextIteration = function () {
    console.log('Next Iteration');

    // IN {
    xhrIn.open('GET', 'http://dic.loc/next_word.php');
    xhrIn.onload = function () {
        console.log(newWord);
        document.getElementById('ctl00_ContentPlaceHolder1_tsearch').value = newWord;
        document.getElementById('ctl00_ContentPlaceHolder1_search').click();

        htmlText = document.getElementById('article_full').innerHTML;
    //    console.log('+');
    //    console.log({
    //        'word': newWord,
    //        'html': htmlText
    //    });
        xhrOut.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        xhrOut.send('word=' + encodeURIComponent(newWord) + '&html=' + encodeURIComponent(htmlText) );
    };
    xhrIn.onreadystatechange = function () {
        var DONE = 4; // readyState 4 means the request is done.
        var OK = 200; // status 200 is a successful return.

        newWord = xhrIn.responseText;
    }
    // IN }

    // OUT {

    xhrOut.open('POST', 'http://dic.loc/save_html.php');
    xhrOut.onload = function () {
        console.log('HTML LOADED');
        NextIteration();
    };
    // OUT }

    xhrIn.send(null);
}

NextIteration();








var xhrOut = new XMLHttpRequest();
xhrOut.open('POST', 'http://dic.loc/save_html.php');

do {
    var newWord = xhr.getNextWord;

    document.getElementById('ctl00_ContentPlaceHolder1_tsearch').value = 'ранок';
    document.getElementById('ctl00_ContentPlaceHolder1_search').click();
    var htmlText = document.getElementById('article_full').innerHTML;

    xhrOut.send({
        'word': newWord,
        'html':htmlText
    });

} while (null != newWord);
