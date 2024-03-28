import { Component, Input } from "@angular/core";
import { Product } from "src/app/shared/models/Product";
import Swal from "sweetalert2";

@Component({
  selector: "app-card-product",
  templateUrl: "./card-product.component.html",
  styleUrls: ["./card-product.component.scss"],
})
export class CardProductComponent {
  @Input("product") product: Product = new Product();
  @Input() isOwner: boolean = false;

  onDeleteProduct() {
    Swal.fire({
      title: "Você tem certeza que deseja excluir esse produto?",
      text: "Essa ação não poderá ser desfeita!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Excluir",
    });
  }
}
