import { HttpClient, HttpParams } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { Product } from "../shared/models/Product";
import { PaginationData } from "../shared/models/PaginationData";
import { IPaginatedResponse } from "../shared/models/IPaginatedResponse.interface";

export interface getProductsParams {
  orderColumn: string;
  orderType: string;
  searchText: string;
}

@Injectable({ providedIn: "root" })
export class ProductsService {
  constructor(private http: HttpClient) {}

  getProducts(
    productsParams: getProductsParams,
    paginationData: PaginationData
  ): Observable<IPaginatedResponse<Product[]>> {
    let params = new HttpParams();
    params = params.append("searchText", productsParams.searchText);
    params = params.append("orderColumn", productsParams.orderColumn);
    params = params.append("orderType", productsParams.orderType);
    params = params.appendAll({ ...paginationData });

    return this.http.get<IPaginatedResponse<Product[]>>("products", { params });
  }
}
