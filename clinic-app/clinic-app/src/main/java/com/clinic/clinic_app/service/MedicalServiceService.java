package com.clinic.clinic_app.service;

import com.clinic.clinic_app.dto.MedicalServiceForm;
import com.clinic.clinic_app.model.MedicalService;
import com.clinic.clinic_app.repository.MedicalServiceRepository;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class MedicalServiceService {

    private final MedicalServiceRepository medicalServiceRepository;

    public MedicalServiceService(MedicalServiceRepository medicalServiceRepository) {
        this.medicalServiceRepository = medicalServiceRepository;
    }

    /**
     * Возвращает активные медицинские услуги, отсортированные по названию.
     *
     * @return список активных услуг
     */
    public List<MedicalService> findActive() {
        return medicalServiceRepository.findByActiveTrueOrderByNameAsc();
    }

    /**
     * Возвращает все медицинские услуги для управления администратором.
     *
     * @return полный список услуг
     */
    public List<MedicalService> findAll() {
        return medicalServiceRepository.findAll();
    }

    /**
     * Находит медицинскую услугу по идентификатору.
     *
     * @param id идентификатор услуги
     * @return найденная медицинская услуга
     * @throws IllegalArgumentException если услуга не найдена
     */
    public MedicalService findById(Long id) {
        return medicalServiceRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Medical service not found"));
    }

    /**
     * Создаёт медицинскую услугу из проверенных данных формы.
     *
     * @param form данные формы услуги
     * @return сохранённая медицинская услуга
     */
    public MedicalService create(MedicalServiceForm form) {
        return save(new MedicalService(), form);
    }

    /**
     * Обновляет существующую медицинскую услугу из проверенных данных формы.
     *
     * @param id идентификатор услуги
     * @param form данные формы услуги
     * @return обновлённая медицинская услуга
     */
    public MedicalService update(Long id, MedicalServiceForm form) {
        return save(findById(id), form);
    }

    /**
     * Удаляет медицинскую услугу по идентификатору.
     *
     * @param id идентификатор услуги
     */
    public void delete(Long id) {
        medicalServiceRepository.deleteById(id);
    }

    /**
     * Преобразует сущность медицинской услуги в объект формы для редактирования.
     *
     * @param service сущность медицинской услуги
     * @return заполненная форма услуги
     */
    public MedicalServiceForm toForm(MedicalService service) {
        MedicalServiceForm form = new MedicalServiceForm();
        form.setName(service.getName());
        form.setDescription(service.getDescription());
        form.setPrice(service.getPrice());
        form.setActive(service.getActive());
        return form;
    }

    private MedicalService save(MedicalService service, MedicalServiceForm form) {
        service.setName(form.getName());
        service.setDescription(form.getDescription());
        service.setPrice(form.getPrice());
        service.setActive(Boolean.TRUE.equals(form.getActive()));
        return medicalServiceRepository.save(service);
    }
}
