import { ProductsService, getProductsParams } from "./../../products.service";
import { Component } from "@angular/core";
import { IPaginatedResponse } from "src/app/shared/models/IPaginatedResponse.interface";
import { PaginationData } from "src/app/shared/models/PaginationData";
import { Product } from "src/app/shared/models/Product";
import Swal from "sweetalert2";

@Component({
  selector: "app-products-list",
  templateUrl: "./products-list.component.html",
  styleUrls: ["./products-list.component.scss"],
})
export class ProductsList {
  productsList: Product[] = [];

  loadingProducts: boolean = true;

  paginationData = new PaginationData();

  constructor(private productService: ProductsService) {}

  getProductsPaginated(
    productsParams: getProductsParams,
    paginationData: PaginationData
  ) {
    this.loadingProducts = true;

    this.productService.getProducts(productsParams, paginationData).subscribe({
      next: (res: IPaginatedResponse<Product[]>) => {
        this.productsList = res.data;
        this.paginationData = {
          ...this.paginationData,
          totalItems: res.totalItems,
        };
        this.loadingProducts = false;
      },
      error: (err: Error) => {
        Swal.fire("Erro ao buscar produtos!", err.message, "error").then(() => {
          this.loadingProducts = false;
        });
      },
    });
  }
}
