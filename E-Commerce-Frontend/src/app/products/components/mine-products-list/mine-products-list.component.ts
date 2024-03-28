import { Component } from "@angular/core";
import { ProductsService, getProductsParams } from "../../products.service";
import { PaginationData } from "src/app/shared/models/PaginationData";
import { Product } from "src/app/shared/models/Product";
import { IPaginatedResponse } from "src/app/shared/models/IPaginatedResponse.interface";
import Swal from "sweetalert2";

@Component({
  selector: "app-products-list",
  templateUrl: "./mine-products-list.component.html",
  styleUrls: ["./mine-products-list.component.scss"],
})
export class MineProductsList {
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
