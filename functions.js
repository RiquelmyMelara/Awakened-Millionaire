function runFramework(action, userId, tagName){
  $.ajax({ url: 'functions.php',
           data: {action: action, user: userId, tag: tagName},
           type: 'POST',
           success: function(output) {
                      console.log(output);
           }
  });
}
