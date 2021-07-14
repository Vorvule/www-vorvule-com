// realTime realCode realTalk realCity
// var realItem = 0;
// var realVide = 0;


function showItem() {
    var hintList = item.getElementsByTagName('li');
    var captList = item.getElementsByTagName('p');
    var factList = fact.getElementsByTagName('li');
    
    var newsQuantity = hintList.length;
        if (realItem > newsQuantity - 1) realItem = 0;
        if (realItem < 0) realItem = newsQuantity - 1;
    
    for (var i = 0; i < newsQuantity; i++) {
        hintList[i].style.color = 'black';
        captList[i].style.color = 'white';
        factList[i].style.display = 'none';
    }
    
    captList[realItem].style.color = 'antiquewhite';
    factList[realItem].style.display = 'block';
    if (realTome == 'video') {}
}


function plusItem(n) {
    switch (realTome) {
        case 'news':
            showItem(realItem += n);
            break;
        case 'video':
            realVide += n;
            var hintList = item.getElementsByTagName('li');
            if (realVide > hintList.length - 1) realVide = 0;
            if (realVide < 0) realVide = hintList.length - 1;
            playVideo(hintList[realVide]);
            break;
    }
    if (fact.style.display == 'block') scrollTop();
}


function currItem(n) {
    switch (realTome) {
        case 'news':
            showItem(realItem = n);
            break;
        case 'video':
            realVide = n;
            var hintList = item.getElementsByTagName('li');
            if (realVide > hintList.length - 1) realVide = 0;
            if (realVide < 0) realVide = hintList.length - 1;
            playVideo(hintList[realVide]);
            break;
    }
 
}


function showFact(index) {
    bodyTPos = document.body.scrollTop;
    currItem(index);
    swapFact();
}


function swapFact() {
    switch (fact.style.display) {
        case 'none': // show fact
            hideShow(item, fact);
            hideShow(factButton, hintButton);
            searchButton.style.display = 'none';
            eraser.style.display = 'none';
            if (look.style.display == 'block') toggleLook();
                scrollTop();
            break;
        case 'block': // show item
            hideShow(fact, item);
            hideShow(hintButton, factButton);
            searchButton.style.display = 'block';
            eraser.style.display = 'block';
                document.body.scrollTo(0, bodyTPos);
            break;
    }
}


function hideShow(hideId, showId) {
    hideId.style.display = 'none';
    showId.style.display = 'block';
}


function playVideo(that) {
    
    ytplayer.src = 'https://www.youtube.com/embed/' + that.className + '?&autoplay=1&enablejsapi=1&origin=https://vorvule.com';
    // ytplayer.src ='https://www.youtube.com/embed?listType=playlist&list=PLwxDzPQHpYnf0v1w7VsU3Br9KjdGmjsMu&amp;index=' + that.id + '&amp;controls=1&amp;loop=1&amp;modestbranding=1&amp;iv_load_policy=3&amp;rel=0&amp;showinfo=0&amp;origin=https%3A%2F%2Fwww.vorvule.com&amp;widgetid=1';
    
    var hintList = item.getElementsByTagName('li');
    for (var i = 0; i < hintList.length; i++) hintList[i].style.color = 'black';
    that.style.color = 'antiquewhite';
    realVide = Number(that.id);
    
    var factList = fact.getElementsByTagName('li');
    for (var i = 0; i < factList.length; i++) factList[i].style.display = 'none';
    factList[realVide].style.display = 'block';
}


function findGlobalElements() {
  
    var realTome = document.getElementsByClassName('w4-main-tome')[tomeIndex];
    
    findArea = realTome.getElementsByClassName('w4-find')[0];
    hintList = realTome.getElementsByClassName('w4-hint')[0];
    factList = realTome.getElementsByClassName('w4-fact')[0];
  
}

// DICTIONARY
function filterDictionary(inputText) {
    if (inputText.length == 0) inputText = 'а';
    ajaxHTML('/index-books/dictionary/dictionary-hint.php?q=' + inputText, hintList);
    hideShow(factList, hintList);
}

// PROVERBS
function filterProverbs(inputText) {
    if (inputText.length == 0) inputText = 'а';
    ajaxHTML('/index-books/proverbs/proverbs-hint.php?q=' + inputText, hintList);
    hideShow(factList, hintList);
}

function showWord(word) {
    factList.innerHTML = '';
    ajaxHTML('/index-books/dictionary/dictionary-show.php?w=' + word, factList);
    hideShow(hintList, factList);
    findArea.value = word;
}
function getContent(filePath, callBack) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callBack(this.responseText);
        }
    };
    xhttp.open("GET", filePath, true);
    xhttp.send();
}

function setContent(obj) {
  var obj = JSON.parse(obj);
  pict.innerHTML = obj['pict'];
  fact.innerHTML = obj['fact'];
}