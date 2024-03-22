import { NgModule } from "@angular/core";
import { RouterModule, Routes } from "@angular/router";
import { ProductsComponent } from "./products.component";
import { ProductsList } from "./components/products-list/products-list.component";

const routes: Routes = [
  {
    path: "",
    component: ProductsComponent,
    children: [{ path: "", component: ProductsList }],
  },
  { path: "**", redirectTo: "" },
];
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProductsRoutingModule {}
