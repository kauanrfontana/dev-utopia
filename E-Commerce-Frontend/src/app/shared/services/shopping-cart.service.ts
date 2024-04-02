import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import {
  IBasicResponseData,
  IBasicResponseMessage,
} from "../models/IBasicResponse.interfaces";
import { Observable } from "rxjs";
import { ShoppingCart } from "../models/ShoppingCart";

@Injectable({ providedIn: "root" })
export class ShoppingCartService {
  constructor(private http: HttpClient) {}

  getShoppingCartData(): Observable<IBasicResponseData<ShoppingCart>> {
    return this.http.get<IBasicResponseData<ShoppingCart>>("shoppingCart");
  }

  addProductToShoppingCart(productId: number): Observable<IBasicResponseMessage> {
    return this.http.post<IBasicResponseMessage>("shoppingCart", { productId });
  }

  removeProductFromShoppingCart(productId: number): Observable<IBasicResponseMessage> {
    return this.http.delete<IBasicResponseMessage>("shoppingCart/" + productId);
  }
}
