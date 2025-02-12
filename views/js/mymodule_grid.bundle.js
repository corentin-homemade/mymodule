/******/ (() => { // webpackBootstrap
/*!*********************!*\
  !*** ./js/index.js ***!
  \*********************/
$(document).ready(function () {
  console.log('Document is ready');
  try {
    var grid = new window.prestashop.component.Grid('product_command');
    console.log('Grid initialized', grid);
    grid.addExtension(new window.prestashop.component.GridExtensions.SortingExtension());
    console.log('SortingExtension added');
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersResetExtension());
    console.log('FiltersResetExtension added');
    grid.addExtension(new window.prestashop.component.GridExtensions.LinkRowActionExtension());
    console.log('LinkRowActionExtension added');
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitRowActionExtension());
    console.log('SubmitRowActionExtension added');
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitGridActionExtension());
    console.log('SubmitGridActionExtension added');
    grid.addExtension(new window.prestashop.component.GridExtensions.PositionExtension());
    console.log('PositionExtension added');
  } catch (error) {
    console.error('Error initializing grid:', error);
  }
});
/******/ })()
;
//# sourceMappingURL=mymodule_grid.bundle.js.map