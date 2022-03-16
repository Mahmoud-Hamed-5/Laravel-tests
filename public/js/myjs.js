function isliked(post_id){
    var xhr = new XMLHttpRequest();

    var url = '/post/isliked/' + post_id;
    xhr.open("GET", url, false);
    var isliked = 0;
    xhr.onload = function () {
        isliked = this.responseText;
  }

  xhr.send();
  return isliked;
}

function like(id , c , b) {
  // Creating XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  var liked = isliked(id);
  xhr.onload = function () {
    isliked = this.responseText;
  }


  if(liked == 1){
    var url = '/post/dislike/' + id;
    classNamew = "fa-regular fa-2x fa-thumbs-up" ;
    document.getElementById("pa").innerHTML = "not liked";
  }
  else{
    var url = '/post/like/' + id;
    classNamew = "fa-regular fa-2x fa-thumbs-down" ;
    //document.getElementById("pa").innerHTML = "liked";
  }

 // Making connection
  xhr.open("POST", url, true);

  // function execute after request is successful
  xhr.onload = function () {
    document.getElementById("likes_counter"+c).innerHTML = " " + this.responseText;

    document.getElementById("like_button"+b).className = classNamew ;
  }
  // Sending request
  xhr.send();
}



