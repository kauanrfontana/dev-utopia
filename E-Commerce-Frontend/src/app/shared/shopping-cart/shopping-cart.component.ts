import { Component, ElementRef, HostListener, ViewChild } from "@angular/core";

@Component({
  selector: "app-shopping-cart",
  templateUrl: "./shopping-cart.component.html",
  styleUrls: ["./shopping-cart.component.scss"],
})
export class ShoppingCartComponent {
  @ViewChild("iconSection") iconSection?: ElementRef;
  cluePosition: "left" | "right" = "right";

  constructor() {
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

  @HostListener("mouseenter") mouseover() {
    this.iconSection?.nativeElement.classList.add(
      "animate",
      "shake",
      "animate--fast"
    );
  }
  @HostListener("mouseleave") mouseleave() {
    this.iconSection?.nativeElement.classList.remove(
      "animate",
      "shake",
      "animate--fast"
    );
  }
}
