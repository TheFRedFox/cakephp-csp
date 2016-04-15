(function () {
  var linkFunction = function () {
    var elements = document.getElementsByClassName('csp-link');

    var linkFunction = function (event) {
      var confirmMessage = this.getAttribute('data-csp-confirm');
      if (confirmMessage !== null && confirmMessage !== 'undefined') {
        if (confirm(confirmMessage)) {
          return true;
        }
        event.returnValue = false;
        event.preventDefault();
        return false;
      }
    };

    for (var i = 0; i < elements.length; i++) {
      var element = elements[i];
      element.onclick = linkFunction;
    }
  };

  var postLinkFunction = function () {
    var elements = document.getElementsByClassName('csp-postLink');

    var postLinkFunction = function (event) {
      var formName = this.getAttribute("data-csp-form");
      var confirmMessage = this.getAttribute('data-csp-confirm');
      if (confirmMessage !== null && confirmMessage !== 'undefined') {
        if (confirm(confirmMessage)) {
          document[formName].submit();
          return false;
        }
        return true;
      }
      document[formName].submit();
      event.returnValue = false;
      event.preventDefault();
      return false;
    };

    for (var i = 0; i < elements.length; i++) {
      var element = elements[i];
      element.onclick = postLinkFunction;
    }
  };

  linkFunction();
  postLinkFunction();
}());
