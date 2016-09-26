@.GalleryController = Mn.Controller.extend
  galleryPage: () ->
    @.showRoot
    @.showGallery(@)
  showGallery: (controller) =>
    gallery = new @.Gallery()
    gallery.fetch()
    galleryView = new @.GalleryView
      collection: gallery
    @.app.root.getRegion('gallery').show(galleryView)
    @.app.root.getRegion('header').empty()
  showAlbum: (id, page = 1) =>
    album = new @.Album({id: id, page: page})
    album.fetch
      success: (album, response, options) ->
        description = album.get("description")
        albumHeader = new @.AlbumHeader
          model: new @.AlbumDescription(description)
        @.app.root.getRegion('header').show(albumHeader)

        images = album.get("images")
        albumImageListView = new @.AlbumImageListView
          collection: new @.ImageCollection(images)
        @.app.root.getRegion('gallery').show(albumImageListView)

        pagination = album.get("pagination")
        paginationView = new @.PaginationView
          model: new @.Pagination(pagination)
        @.app.root.getRegion('pagination').show(paginationView)
  showRoot: =>
    @.app.root.render()
@.GalleryRouter = Mn.AppRouter.extend
  appRoutes:
    '': 'galleryPage'
    'album/:id': 'showAlbum'
    'album/:id/page/:page': 'showAlbum'