@.Image = Backbone.Model.extend
  defaults:
    title: 'image'
    url: 'image url'

@.Album = Backbone.Collection.extend
  model: @.Image
  url: "/albums/#{@.albumId}"

@.AlbumPreview = Backbone.Model.extend
  defaults:
    title: 'Album'
    url: ""

@.Gallery = Backbone.Collection.extend
  model: @.AlbumPreview
  url: "/api/albums"

@.Pagination = Backbone.Model.extend
  defaults:
    currentPage: 1
    pages: [1]
  url: "/api/pagination"