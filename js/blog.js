/* global Parse, Handlebars */

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
    var BlogsView =  Parse.View.extend({
        template: Handlebars.compile($('#blogs-tpl').html()),
        render: function(){ 
            var collection = { blog: this.collection.toJSON() };
            this.$el.html(this.template(collection));
        }
    });    
    
    var blogs = new Blogs();
    blogs.fetch({
        success: function(blogs) {
            var blogsView = new BlogsView({ collection: blogs });
            blogsView.render();
            $('.demo-blog__posts').html(blogsView.el);
        },
        error: function(blogs, error) {
            console.log(error);
        }
    });
 
});