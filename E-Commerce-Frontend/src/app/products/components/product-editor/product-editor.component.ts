import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { Product } from "src/app/shared/models/Product";
import Swal from "sweetalert2";

@Component({
  selector: "app-product-editor",
  templateUrl: "./product-editor.component.html",
  styleUrls: ["./product-editor.component.css"],
})
export class ProductEditorComponent implements OnInit {
  btnHover: boolean = false;

  urlPreviewImage: string = "";

  productData = new Product();
  constructor(private router: Router) {}

  ngOnInit() {}

  previewImageDoestLoaded() {
    this.urlPreviewImage = "";
    Swal.fire(
      "Erro ao carregar prévia da imagem!",
      "Link informado é inválido!",
      "error"
    );
  }

  goBack() {
    this.router.navigate(["/products"]);
  }
}
