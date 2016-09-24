@.RootLayout = Marionette.LayoutView.extend
  el: "#main"
  regions:
    gallery: "#gallery"
    pagination: "#pagination"

@.ImageView = Marionette.ItemView.extend
  template: "#image-view-template"

@.AlbumView = Marionette.CollectionView.extend
  childView: @.ImageView

@.AlbumPreview = Marionette.ItemView.extend
  template: "#album-view-template"
  events:
    'click a': 'navigateToAlbum'
  navigateToAlbum: ->
    @.navigateTo(@.model.id)
  navigateTo: (id) =>
    @.controller.router.navigate("album/#{id}", {trigger: true})

@.GalleryView = Marionette.CollectionView.extend
  childView: @.AlbumPreview

@.PaginationView = Marionette.ItemView.extend
  template: "#pagination-view-template"