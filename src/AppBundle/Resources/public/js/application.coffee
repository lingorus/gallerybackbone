App = Mn.Application.extend
  region: '#main'
  setRootLayout: (app) =>
    console.log 'set root layout'
    app.root = new @.RootLayout()
@.app = new App

@.app.on(
  'before:start'
  ->
    app.setRootLayout(@)
)

@.app.on(
  'start'
  =>
    @.controller = new @.GalleryController()
    @.controller.router = new @.GalleryRouter
      controller: @.controller
    Backbone.history.start({pushState: true})
    console.log('app is started')
)