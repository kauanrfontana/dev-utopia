import { Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { PaginationData } from "src/app/shared/models/PaginationData";
import { Review } from "src/app/shared/models/Review";
import { ProductsService } from "../../products.service";
import { IPaginatedResponse } from "src/app/shared/models/IPaginatedResponse.interface";
import Swal from "sweetalert2";
import { IBasicResponseMessage } from "src/app/shared/models/IBasicResponse.interfaces";

@Component({
  selector: "app-product-reviews",
  templateUrl: "./product-reviews.component.html",
  styleUrls: ["./product-reviews.component.css"],
})
export class ProductReviewsComponent implements OnInit {
  reviewsList: Review[] = [];

  ownReview = new Review();

  paginationData = new PaginationData();

  @Input() productId: number = 0;
  @Output() loadingReviews = new EventEmitter<boolean>(false);

  constructor(private productsService: ProductsService) {}

  ngOnInit() {
    this.getReviewsData();
  }

  setReviewRating(value: number) {
    this.ownReview.stars = value;
  }

  getReviewsData() {
    this.loadingReviews.emit(true);
    this.productsService
      .getProductReviews(this.productId, this.paginationData)
      .subscribe({
        next: (res: IPaginatedResponse<Review[]>) => {
          this.reviewsList = res.data;
          this.paginationData.totalItems = res.totalItems;
          this.loadingReviews.emit(false);
        },
        error: (err: Error) => {
          Swal.fire("Erro ao consultar avaliações!", err.message, "error");
          this.loadingReviews.emit(false);
        },
      });
  }

  insertReview() {
    if (!this.ownReview.review) {
      Swal.fire(
        "Erro ao adicionar avaliação!",
        "o campo descreva a avaliação é obrigatório!",
        "error"
      );
    }
    if (!this.ownReview.stars) {
      Swal.fire(
        "Erro ao adicionar avaliação!",
        "o campo estrelas é obrigatório!",
        "error"
      );
    }
    Swal.fire({
      title: "Confirmação",
      text: "Deseja realmente cadastrar esta avaliação?",
      icon: "question",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Confirmar",
      preConfirm: () => {
        return this.productsService
          .insertReview(this.productId, this.ownReview)
          .subscribe({
            next: (res: IBasicResponseMessage) => {
              Swal.fire("Sucesso", res.message, "success").then(() => {
                this.getReviewsData;
              });
            },
            error: (err: Error) => {
              Swal.fire("Erro ao adicionar avaliação!", err.message, "error");
            },
          });
      },
    }).then((result) => {
      if (result.dismiss) return;
    });
  }

  pageChanged(event: any) {
    this.paginationData = {
      ...this.paginationData,
      currentPage: event.pageIndex + 1,
      itemsPerPage: event.pageSize,
    };
    this.getReviewsData();
  }
}
