/* global Parse */

$(function() {
    Array.prototype.forEach.call(document.querySelectorAll('.mdl-card__media'), function(el) {
      var link = el.querySelector('a');
      if(!link) {
        return;
      }
      var target = link.getAttribute('href');
      if(!target) {
        return;
      }
      el.addEventListener('click', function() {
        location.href = target;
      });
    });
 
    Parse.$ = jQuery;
 
    // Replace this line with the one on your Quickstart Guide Page
    Parse.initialize("asBFKXw6alVzEkNvqPAtkKeHNMJ50m5lpibJ4Tax", "pGrNOksA1YKtW48YS0jRaOmwsm19jVYd8MyFY7J9");
    var Blog = Parse.Object.extend("Blog");
    var Blogs = Parse.Collection.extend({
        model: Blog
    });
    var blogs = new Blogs();
    blogs.fetch({
        success: function(blogs) {
            console.log(blogs);
        },
        error: function(blogs, error) {
            console.log(error);
        }
    });
 
});