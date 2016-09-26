@.RootLayout = Marionette.LayoutView.extend
  el: "#main"
  regions:
    gallery: "#gallery"
    header: "#header"
    pagination: "#pagination"

@.AlbumHeader = Marionette.ItemView.extend
  template: "#album-header-view-template"

@.ImageView = Marionette.ItemView.extend
  template: "#image-view-template"

@.AlbumImageListView = Marionette.CollectionView.extend
  childView: @.ImageView

@.AlbumPreview = Marionette.ItemView.extend
  template: "#album-view-template"
  events:
    'click .photo': 'navigateToAlbum'
  navigateToAlbum: ->
    @.navigateTo(@.model.id)
  navigateTo: (id) =>
    @.controller.router.navigate("album/#{id}", {trigger: true})

@.GalleryView = Marionette.CollectionView.extend
  childView: @.AlbumPreview

@.PaginationView = Marionette.ItemView.extend
  template: "#pagination-view-template"
  events:
    "click .paginationLink": (e) ->
      page = $(e.currentTarget).data('page')
      @.navigateToPage(@.model.get("albumId"), page)
  navigateToPage: (albumId, page) =>
    @.controller.router.navigate("album/#{albumId}/page/#{page}", {trigger: true})
