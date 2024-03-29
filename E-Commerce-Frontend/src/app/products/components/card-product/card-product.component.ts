import { Component, EventEmitter, Input, Output } from "@angular/core";
import { Product } from "src/app/shared/models/Product";
import Swal from "sweetalert2";
import { ProductsService } from "../../products.service";
import { IBasicResponseMessage } from "src/app/shared/models/IBasicResponse.interfaces";

@Component({
  selector: "app-card-product",
  templateUrl: "./card-product.component.html",
  styleUrls: ["./card-product.component.scss"],
})
export class CardProductComponent {
  @Input("product") product: Product = new Product();
  @Input() isOwner: boolean = false;

  constructor(private productsService: ProductsService) {}

  onDeleteProduct() {
    Swal.fire({
      title: "Você tem certeza que deseja excluir esse produto?",
      text: "Essa ação não poderá ser desfeita!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Excluir",
      preConfirm: () => {
        return this.productsService.deleteProduct(this.product.id).subscribe({
          next: (res: IBasicResponseMessage) => {
            Swal.fire("Sucesso", res.message, "success").then(() =>{
              this.productsService.onDeleteProductEvent.next();
            });
          },
          error: (err: Error) => {
            Swal.fire("Erro ao excluir produto!", err.message, "error");
          },
        });
      }
    }).then((result) => {
      if(result.dismiss) return;
    });
  }
}
