@.Image = Backbone.Model.extend
  defaults:
    title: 'image'
    url: 'image url'
@.ImageCollection = Backbone.Collection.extend
  model: @.Image

@.AlbumDescription = Backbone.Model.extend({})


@.Album = Backbone.Model.extend
  url: ->
    "/api/album/#{@.get('id')}/page/#{@.get('page')}"
@.AlbumPreview = Backbone.Model.extend
  defaults:
    title: 'Album'
    url: ""

@.Gallery = Backbone.Collection.extend
  model: @.AlbumPreview
  url: "/api/albums"

@.Pagination = Backbone.Model.extend({})