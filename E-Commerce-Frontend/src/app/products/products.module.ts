import { NgModule } from "@angular/core";
import { SharedModule } from "../shared/shared.module";
import { ProductsComponent } from "./products.component";
import { ProductsRoutingModule } from "./products-routing.module";
import { ProductsList } from "./components/products-list/products-list.component";
import { CardProductComponent } from "./components/card-product/card-product.component";
import { MatTabsModule } from "@angular/material/tabs";

@NgModule({
  declarations: [ProductsComponent, ProductsList, CardProductComponent],
  imports: [SharedModule, ProductsRoutingModule, MatTabsModule],
  providers: [],
})
export class ProductsModule {}
