import { NgModule } from "@angular/core";
import { RouterModule, Routes } from "@angular/router";
import { ProductsComponent } from "./products.component";
import { ProductsList } from "./components/products-list/products-list.component";
import { MineProductsList } from "./components/mine-products-list/mine-products-list.component";
import { ProductEditorComponent } from "./components/product-editor/product-editor.component";

const routes: Routes = [
  {
    path: "",
    component: ProductsComponent,
    children: [
      { path: "", component: ProductsList },
      {
        path: "mine",
        component: MineProductsList,
      },
    ],
  },
  { path: "edit/:id", component: ProductEditorComponent },
  { path: "create", component: ProductEditorComponent },
  { path: "**", redirectTo: "" },
];
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProductsRoutingModule {}
