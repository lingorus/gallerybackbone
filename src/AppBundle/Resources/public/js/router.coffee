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
  showAlbum: (id) =>
    album = new @.Album()
    album.albumId = id
    console.log album
    album.fetch()
    albumView = new @.AlbumView
      collection: album
    @.app.root.getRegion('gallery').show(albumView)

  showRoot: =>
    @.app.root.render()
@.GalleryRouter = Mn.AppRouter.extend
  appRoutes:
    '': 'galleryPage'
    'album/:id': 'showAlbum'