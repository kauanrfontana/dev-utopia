import { Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { IListItem } from "../search-select/IListItem.interface";
import { IBasicResponseData } from "../../models/IBasicResponse.interfaces";
import { ILocation, LocationSevice } from "../../services/location.service";
import { Observable, debounceTime, map } from "rxjs";
import Swal from "sweetalert2";
import { FormControl } from "@angular/forms";

export class LocationData {
  constructor(
    public stateId: number = 0,
    public cityId: number = 0,
    public address: string = "",
    public houseNumber: string = "",
    public complement: string = "",
    public zipCode: string = ""
  ) {}
}
@Component({
  selector: "app-location",
  templateUrl: "./location.component.html",
  styleUrls: ["./location.component.css"],
})
export class LocationComponent implements OnInit {
  @Input() dataUpdated = new LocationData();
  @Output() dataUpdatedChanged = new EventEmitter<LocationData>();
  @Input() dataBefore = new LocationData();
  @Input() isEditing: boolean = false;
  @Output() loadingData = new EventEmitter<boolean>();

  loadingCepSearch: boolean = false;

  btnHover: boolean = false;

  cepControl: FormControl = new FormControl(null);

  states: IListItem[] = [];
  cities: IListItem[] = [];

  constructor(private locationService: LocationSevice) {}

  ngOnInit() {
    console.log(this.dataBefore);
    this.cepControlValueChanges();
    this.getStates();
    if (this.dataBefore.stateId) {
      this.getCitiesByState(this.dataBefore.stateId).subscribe({
        next: (res: IBasicResponseData<IListItem[]>) => {
          this.cities = res.data;
          this.loadingData.emit(false);
        },
        error: (err: Error) => {
          Swal.fire("Erro ao consultar cidades!", err.message, "error");
          this.loadingData.emit(false);
        },
      });
    } else {
      this.loadingData.emit(false);
    }
  }

  cepControlValueChanges() {
    this.cepControl.valueChanges.pipe(debounceTime(1000)).subscribe((value) => {
      if (value.length == 8) {
        this.searchLocationByCep(value);
      }
    });
  }

  searchLocationByCep(cep: string) {
    this.loadingCepSearch = true;

    this.locationService.getLocationByCep(cep).subscribe({
      next: (
        res: IBasicResponseData<{
          address: string;
          city: string;
          state: string;
        }>
      ) => {
        this.dataUpdated.address = res.data.address;
        this.dataUpdatedChanged.emit(this.dataUpdated);
        this.dataUpdated.stateId = Number(
          this.states.find((state) => state.label == res.data.state)?.id
        );
        this.dataUpdatedChanged.emit(this.dataUpdated);
        this.getCitiesByState(this.dataUpdated.stateId).subscribe({
          next: (res2: IBasicResponseData<IListItem[]>) => {
            this.cities = res2.data;
            this.dataUpdated.cityId = Number(
              this.cities.find((city) => city.label == res.data.city)?.id
            );
            this.dataUpdatedChanged.emit(this.dataUpdated);
            this.loadingCepSearch = false;
          },
          error: (err: Error) => {
            Swal.fire("Erro ao consultar cidades!", err.message, "error");
          },
        });
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cep!", err.message, "error");
        this.loadingCepSearch = false;
      },
    });
  }

  getStates() {
    this.locationService.getStates().subscribe({
      next: (res: IBasicResponseData<ILocation[]>) => {
        this.states = res.data.map((state: { id: number; name: string }) => ({
          id: state.id,
          label: state.name,
        }));
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar países!", err.message, "error");
      },
    });
  }

  getCitiesByState(
    stateId: number
  ): Observable<IBasicResponseData<IListItem[]>> {
    return this.locationService.getCitiesByState(stateId).pipe(
      map((response: IBasicResponseData<ILocation[]>) => {
        return {
          data: response.data.map((city: { id: number; name: string }) => ({
            id: city.id,
            label: city.name,
          })),
        };
      })
    );
  }

  onStateChange(stateId: number) {
    this.cities = [];
    this.getCitiesByState(stateId).subscribe({
      next: (res: IBasicResponseData<IListItem[]>) => {
        this.cities = res.data;
      },
      error: (err: Error) => {
        Swal.fire("Erro ao consultar cidades!", err.message, "error");
      },
    });
  }

  getStateLabelById(id: number): string | undefined {
    return this.states.find((state) => state?.id == +id)?.label;
  }

  getCityLabelById(id: number): string | undefined {
    return this.cities.find((city) => city?.id == +id)?.label;
  }
}
