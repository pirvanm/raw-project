const searchButton = document.getElementById('searchButton');
const searchInput = document.getElementById('searchInput');
const resultsDiv = document.getElementById('searchResults');

let searchResults = [];

searchButton.onclick = function (e) {
    e.preventDefault();

    if (searchInput.value == '') {
        alert('The search input can not be empty.');
        resultsDiv.innerHTML = '';
        return;
    }

    var ob_ajax = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); 
  
    // prepare url
    var  url = 'http://127.0.0.1?q='+searchInput.value;
  
    ob_ajax.open("GET", url, true);			// create request
    ob_ajax.send(null);		// send request
  
    // check request
    // make sure we got correct answer
    ob_ajax.onreadystatechange = function() {
      if (ob_ajax.readyState == 4) {
        searchResults = JSON.parse(ob_ajax.responseText);

        let result = '';

        // create html for results
        searchResults.forEach(function (book, i) {
            result += `
                <div class="search-result">
                    <div class="author">${book.author}</div>
                    <div class="book">${book.name}</div>
                </div>
            `;
        });

        resultsDiv.innerHTML = result;

        let i = 1;
        for (const child of resultsDiv.children) {
            
            setTimeout(function(){
                child.style.opacity = 1;
                child.style.transform = "translateX(0px)";
                },200 * i);
            i++;
          }
      }
    }
};
