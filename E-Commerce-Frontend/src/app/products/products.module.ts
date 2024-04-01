import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { ProductsComponent } from "./products.component";
import { ProductsRoutingModule } from "./products-routing.module";
import { ProductsListComponent } from "./components/products-list/products-list.component";
import { CardProductComponent } from "./components/card-product/card-product.component";
import { MatTabsModule } from "@angular/material/tabs";
import { ProductsFiltersComponent } from "./components/products-filters/products-filters.component";
import { ProductEditorComponent } from "./components/product-editor/product-editor.component";
import { MyProductsListComponent } from "./components/my-products-list/my-products-list.component";
import { ViewProductComponent } from './components/view-product/view-product.component';

@NgModule({
  declarations: [
    ProductsComponent,
    ProductsListComponent,
    CardProductComponent,
    ProductsFiltersComponent,
    ProductEditorComponent,
    MyProductsListComponent,
    ViewProductComponent
  ],
  imports: [SharedModule, ProductsRoutingModule, MatTabsModule],
  providers: [],
})
export class ProductsModule {}
