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

  constructor(private shoppingCartService: ShoppingCartService) {
    if (window.innerWidth < 980) {
      this.cluePosition = "left";
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
  onMouseEnter() {
    this.iconSection?.nativeElement.classList.add(
      "animate",
      "shake",
      "animate--fast"
    );
  }

  onMoouseLeave() {
    this.iconSection?.nativeElement.classList.remove(
      "animate",
      "shake",
      "animate--fast"
    );
  }

  getShoppingCartData() {
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
}
