import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { ProductsComponent } from "./products.component";
import { ProductsRoutingModule } from "./products-routing.module";
import { ProductsList } from "./components/products-list/products-list.component";
import { CardProductComponent } from "./components/card-product/card-product.component";
import { MatTabsModule } from "@angular/material/tabs";
import { MineProductsList } from "./components/mine-products-list/mine-products-list.component";
import { ProductsFiltersComponent } from "./components/products-filters/products-filters.component";
import { ProductEditorComponent } from "./components/product-editor/product-editor.component";

@NgModule({
  declarations: [
    ProductsComponent,
    ProductsList,
    CardProductComponent,
    MineProductsList,
    ProductsFiltersComponent,
    ProductEditorComponent,
  ],
  imports: [SharedModule, ProductsRoutingModule, MatTabsModule],
  providers: [],
})
export class ProductsModule {}
