import { Component, ElementRef, HostListener, ViewChild } from "@angular/core";
import { ShoppingCartService } from "../services/shopping-cart.service";
import { ShoppingCart } from "../models/ShoppingCart";
import { IBasicResponseData } from "../models/IBasicResponse.interfaces";
import Swal from "sweetalert2";

@Component({
  selector: "app-shopping-cart",
  templateUrl: "./shopping-cart.component.html",
  styleUrls: ["./shopping-cart.component.scss"],
})
export class ShoppingCartComponent {
  @ViewChild("iconSection") iconSection?: ElementRef;
  cluePosition: "left" | "right" = "right";
  dropdownShowing: boolean = false;

  shoppingCartData = new ShoppingCart();

  constructor(private shoppingCartService: ShoppingCartService, private elementRef: ElementRef) {
    if (window.innerWidth < 980) {
      this.cluePosition = "left";
    }
  }

  @HostListener('document:click', ['$event.target'])
  public onClick(targetElement: HTMLElement): void {
    const clickedInside = this.elementRef.nativeElement.contains(targetElement);
    if (!clickedInside) {
      if(this.dropdownShowing){
        this.doAnimation();
        this.dropdownShowing = false;
      }
    }
  }

  @HostListener("window:resize", ["$event"])
  onResize() {
    if (window.innerWidth < 980) {
      this.cluePosition = "left";
    } else {
      this.cluePosition = "right";
    }
  }

  doAnimation(){
    this.iconSection?.nativeElement.classList.add(
      "animate",
      "shake",
      "animate--fast"
    );

    setTimeout(() => {
      this.iconSection?.nativeElement.classList.remove(
        "animate",
        "shake",
        "animate--fast"
      );
    }, 500);
  }

  getShoppingCartData() {
    this.doAnimation();

    if (!this.dropdownShowing) {
      this.dropdownShowing = true;
      this.shoppingCartService.getShoppingCartData().subscribe({
        next: (res: IBasicResponseData<ShoppingCart>) => {
          this.shoppingCartData = res.data;
        },
        error: (err: Error) => {
          Swal.fire("Erro ao consultar carrinho!", err.message, "error");
        },
      });
    } else {
      this.dropdownShowing = false;
    }
  }

  onRemoveProduct(productId: number) {
    this.shoppingCartService.removeProductFromShoppingCart(productId).subscribe({
      next: (res) => {
        Swal.fire("Sucesso", res.message, "success").then(() => {
          this.getShoppingCartData();
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao remover produto!", err.message, "error");
      },
    });
  }
}
